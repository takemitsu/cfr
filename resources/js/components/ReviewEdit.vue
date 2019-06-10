<template>
    <section id="project-edit">

        <div class="small" style="margin: 10px 0;">
            <router-link :to="{name: 'project-detail'}">{{project.title}}</router-link>
        </div>

        <h3 v-if="form.id">Review Edit</h3>
        <h3 v-else>New Review</h3>

        <div v-show="!is_confirm">

            <div class="form-group">
                <label>ニックネーム (必須)</label>
                <input v-model="form.nickname" class="form-control" placeholder="ニックネーム">
            </div>

            <div class="form-group">
                <label>商品名等（あれば。省略可）</label>
                <input v-model="form.product_name" class="form-control" placeholder="商品名など">
            </div>

            <!-- TODO: Star 系のコンポーネント -->
            <div class="form-group">
                <label>商　品</label>
                <input v-model="form.score_product" type="range" class="custom-range" min="1" max="5">
            </div>
            <div class="form-group">
                <label>実行者</label>
                <input v-model="form.score_vendor" type="range" class="custom-range" min="1" max="5">
            </div>
            <div class="form-group">
                <label>再購買</label>
                <input v-model="form.score_retry" type="range" class="custom-range" min="1" max="5">
            </div>
            <div class="form-group">
                <label>総合的</label>
                <input v-model="form.score_total" type="range" class="custom-range" min="1" max="5">
            </div>

            <div class="form-group">
                <label>コメント</label>
                <textarea v-model="form.comment" class="form-control" rows="6" placeholder="コメント"></textarea>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" @click="change_confirm()">check</button>
            </div>

        </div>
        <div v-show="is_confirm">
            <div class="form-group">


                <div v-if="form.product_name" style="margin-bottom: 10px;">商品名: {{form.product_name}}</div>
                <div style="white-space: pre-wrap; margin-bottom: 10px;">{{form.comment}}</div>
                <div><small>商品の評価:</small> {{form.score_product}}</div>
                <div><small>実行者評価:</small> {{form.score_vendor}}</div>
                <div><small>再購買意欲:</small> {{form.score_retry}}</div>
                <div><small>総合的評価:</small> {{form.score_total}}</div>
                <div class="text-right">{{form.nickname}}</div>


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
                    nickname: null,
                    product_name: null,
                    comment: null,

                    score_product: 3,
                    score_vendor: 3,
                    score_retry: 3,
                    score_total: 3,
                },
                is_confirm: false,
                project: {},
            }
        },
        async mounted() {
            this.initFormData()
            if (this.$route.params.id) {
                await this.getProject(this.$route.params.id)

                if (this.$route.params.review_id) {
                    await this.getReview(this.$route.params.id, this.$route.params.review_id)
                }
            }

        },
        methods: {
            initFormData() {
                this.is_confirm = false
                this.form = {
                    id: null,
                    nickname: null,
                    product_name: null,
                    comment: null,

                    score_product: 3,
                    score_vendor: 3,
                    score_retry: 3,
                    score_total: 3,
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
                        this.project = res.data
                    })
                    .catch(e => {
                        console.error(e)
                        alert('エラーが発生しました。トップに移動します。')
                        this.$router.push({'name': 'top'})
                    })
            },
            async getReview(project_id, review_id) {
                return axios.get('/project/' + encodeURIComponent(project_id) + '/review/' + encodeURIComponent(review_id))
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
                var url = 'project/' + encodeURIComponent(this.project.id) + '/review'

                if (this.form.id) {
                    method = 'put'
                    url = url + '/' + encodeURIComponent(this.form.id)
                }
                axios({
                    method: method,
                    url: url,
                    data: this.form
                })
                    .then(res => {
                        this.$router.push({'name': 'project-detail'})
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
