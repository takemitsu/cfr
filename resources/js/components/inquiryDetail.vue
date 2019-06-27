<template>
    <section id="project-detail" class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12" v-if="inquiry">

            <h3>ご質問・ご感想・ご要望などの詳細</h3>

            <div style="margin-bottom: 20px;">
                <div>ニックネーム: {{inquiry.nickname}}</div>
                <div style="white-space: pre-wrap">{{inquiry.comment}}</div>
            </div>


            <div>
                <div class="form-group">
                    <label>ニックネーム (必須)</label>
                    <input v-model="form.nickname" class="form-control" placeholder="ニックネーム">
                </div>

                <div class="form-group">
                    <label>回答など (必須)</label>
                    <textarea v-model="form.comment" class="form-control" rows="3" placeholder="コメント"></textarea>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" @click="submit()">投稿する！</button>
                </div>
            </div>


            <div v-for="detail in inquiry.details">
                <hr>
                <div style="white-space: pre-wrap; margin-bottom: 10px;">{{detail.comment}}</div>
                <div class="text-right">{{detail.nickname}}</div>
                <div class="text-right">{{detail.updated_at}}</div>

            </div>

            <div v-if="inquiry.details.length === 0">
                返信が登録されていません。
            </div>





        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                params: {
                    page: 1,
                },
                inquiry: {
                    comment: null,
                    nickname: null,
                    details: [],
                },
                inquiry_id: this.$route.params.id,
                form: {
                    nickname: null,
                    comment: null,
                }
            }
        },
        mounted() {
            this.getInquiry()
            this.initFormData()
            this.form.nickname = null
        },
        methods: {
            async getInquiry() {
                return axios.get('inquiry/' + encodeURIComponent(this.inquiry_id))
                    .then(res => {
                        this.inquiry = res.data
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            initFormData() {
                this.form.comment = null
            },
            submit() {
                var method = 'post'
                var url = 'inquiry/' + encodeURIComponent(this.inquiry_id)

                axios({
                    method: method,
                    url: url,
                    data: this.form
                })
                    .then(res => {
                        this.getInquiry()
                        this.initFormData()
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
