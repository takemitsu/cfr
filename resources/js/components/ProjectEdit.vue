<template>
    <section id="project-edit">

        <h3 v-if="form.id">Project Edit</h3>
        <h3 v-else>New Project</h3>

        <div v-show="!is_confirm">

            <div class="form-group">
                <label>公式サイトURL:</label>
                <div class="input-group">
                    <input v-model="form.url" class="form-control" placeholder="公式サイトURL">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-primary" @click="getOgp()">OGP取得</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>プロジェクトタイトル:</label>
                <input v-model="form.title" class="form-control" placeholder="プロジェクトタイトル">
            </div>

            <div class="form-group">
                <label>説明等</label>
                <textarea v-model="form.description" class="form-control" rows="6" placeholder="description"></textarea>
            </div>

            <div class="form-group">
                image url:
                <input v-model="form.image_url" class="form-control" placeholder="image url">
                <div v-if="form.image_url">
                    <img :src="form.image_url">
                </div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" @click="change_confirm()">check</button>
            </div>

        </div>
        <div v-show="is_confirm">
            <div class="form-group">
                <div v-if="form.image_url">
                    <img :src="form.image_url">
                    <hr>
                </div>
                <div>プロジェクトタイトル</div>
                <div style="font-weight: bold;margin-bottom: 20px;">{{form.title}}</div>
                <div>{{form.description}}</div>
                <div style="margin-top: 20px;">公式サイトURL</div>
                <div>{{form.url}}</div>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-secondary" @click="is_confirm=false">edit</button>
                <button type="button" class="btn btn-primary" @click="submit()">finish</button>
            </div>
        </div>


    </section>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    id: null,
                    url: null,
                    title: null,
                    image_url: null,
                    description: null,
                },
                is_confirm: false,
            }
        },
        async mounted() {
            this.initFormData()
            if (this.$route.params.id) {
                await this.getProject(this.$route.params.id)
            }
        },
        methods: {
            initFormData() {
                this.is_confirm = false
                this.form = {
                    id: null,
                    url: null,
                    title: null,
                    image_url: null,
                    description: null,
                    service_id: null,
                }
            },
            async getOgp() {

                return axios.get('/ogp', {
                    params: {
                        url: this.form.url,
                    }
                })
                    .then(res => {
                        console.log(res)
                        if (res.data && res.data.og) {
                            this.form.title = res.data.og['og:title']
                            this.form.image_url = res.data.og['og:image']
                            this.form.description = res.data.og['og:description']
                        }
                    })
                    .catch(e => {
                        console.error(e)
                        alert('取得できませんでした。URLをご確認ください。')
                    })
            },
            async getProject(id) {
                return axios.get('/project/' + encodeURIComponent(id))
                    .then(res => {
                        console.log(res)
                        this.form = res.data
                    })
                    .catch(e => {
                        console.error(e)
                        alert('エラーが発生しました。トップに移動します。')
                        this.$router.push({'name': 'top'})
                    })
            },

            change_confirm() {
                this.is_confirm = true
            },

            submit() {
                var method = 'post'
                var url = 'project'

                if (this.form.id) {
                    method = 'put'
                    url = 'project/' + encodeURIComponent(this.form.id)
                }
                axios({
                    method: method,
                    url: url,
                    data: this.form
                })
                    .then(res => {
                        this.$router.push({'name': 'top'})
                    })
                    .catch(error => {
                        console.error(error)
                        if (error.response && error.response.status === 500 && error.response.data && error.response.data.message) {
                            alert('エラーが発生しました\n' + error.response.data.message)
                            return
                        }

                        if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx
                            console.log(error.response.data);
                            console.log(error.response.status);
                            console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);

                        alert('エラーが発生しました。\n入力値をご確認ください。')

                    })
            }
        }
    }
</script>

<style scoped>
    img {
        max-height: 200px;
        max-width: 200px;
    }
</style>
