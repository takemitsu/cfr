<template>
    <section id="inquiry" class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12">

            <h3>ご質問・ご感想・ご要望など</h3>

            <div v-show="!is_confirm">

                <div class="form-group">
                    <label>ニックネーム (必須)</label>
                    <input v-model="form.nickname" class="form-control" placeholder="ニックネーム">
                </div>

                <div class="form-group">
                    <label>ご質問・ご感想・ご要望など (必須)</label>
                    <textarea v-model="form.comment" class="form-control" rows="6" placeholder="コメント"></textarea>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" @click="change_confirm()">確認する！</button>
                </div>

            </div>
            <div v-show="is_confirm">
                <div class="form-group">
                    <div style="white-space: pre-wrap; margin-bottom: 10px;">{{form.comment}}</div>
                    <div class="text-right">{{form.nickname}}</div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-secondary btn-block" @click="is_confirm=false">戻って編集する</button>

                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-block" @click="submit()">
                        投稿する！
                    </button>
                </div>
            </div>

            <h3 class="mt-3">リスト</h3>

            <div v-if="inquiries.total === 0">
                <div class="alert alert-warning">
                    ご質問・ご感想などの投稿は現在ありません。
                </div>
            </div>
            <div v-else>

                <div v-for="inquiry of inquiries.data">
                    <hr>
                    <div style="white-space: pre-wrap; margin-bottom: 10px;">{{inquiry.comment}}</div>
                    <div>
                        回答数: {{inquiry.details_count}}
                        <div style="float: right;">{{inquiry.nickname}}</div>
                    </div>

                    <div>
                        <router-link class="btn btn-primary btn-sm" :to="{name: 'inquiry-detail', params: {id: inquiry.id}}">
                            詳細へ
                        </router-link>

                        <span style="margin-left: 10px;" v-if="inquiry.status === 0">未回答</span>
                        <span style="margin-left: 10px;" v-if="inquiry.status === 1">回答済み</span>
                        <span style="margin-left: 10px;" v-if="inquiry.status === 9">その他</span>

                        <div style="float:right;">{{inquiry.updated_at}}</div>
                    </div>
                </div>



                <div class="text-center">
                    {{inquiries.to}} / {{inquiries.total}} を表示中
                </div>
                <div v-if="inquiries.total > inquiries.to" class="text-center">
                    <button type="button" @click="loadMore()" class="btn btn-secondary">More Reviews</button>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import StarRating from 'vue-star-rating'

    export default {
        components: {
            StarRating,
        },
        data() {
            return {
                form: {
                    id: null,
                    nickname: null,
                    comment: null,
                },
                is_confirm: false,
                inquiries: {},
                params: {
                    page: 1,
                }
            }
        },
        async mounted() {
            this.initFormData()
            await this.getInquiries()
        },
        methods: {
            initFormData() {
                this.is_confirm = false
                this.form = {
                    id: null,
                    nickname: null,
                    comment: null,
                }
            },
            async getInquiries() {
                return axios.get('/inquiry',  {params: this.params})
                    .then(res => {
                        if (res.data.current_page === 1) {
                            this.inquiries = res.data
                        } else {
                            const response = res.data
                            this.inquiries.from = response.from
                            this.inquiries.to = response.to
                            this.inquiries.current_page = response.current_page
                            this.inquiries.per_page = response.per_page
                            this.inquiries.total = response.total

                            for (let inquiry of res.data.data) {
                                this.inquiries.data.push(inquiry)
                            }
                        }

                    })
                    .catch(e => {
                        console.error(e)
                        alert('エラーが発生しました。トップに移動します。')
                        this.$router.push({'name': 'top'})
                    })
            },
            loadMore() {
                this.params.page = this.inquiries.current_page + 1
                this.getInquiries()
            },

            change_confirm() {

                if (this.form.nickname == null) {
                    alert('ニックネームを入力してください')
                    return
                }
                if (this.form.comment == null) {
                    alert('コメントを入力してください')
                    return
                }

                this.is_confirm = true
            },

            submit() {
                var method = 'post'
                var url = 'inquiry'

                axios({
                    method: method,
                    url: url,
                    data: this.form
                })
                    .then(res => {
                        this.getInquiries()
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
