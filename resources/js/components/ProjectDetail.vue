<template>
    <section id="project-detail" class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12">
            <div v-if="project" style="margin-bottom: 20px;">

                <div v-if="project.image_url">
                    <img :src="project.image_url" style="margin-bottom: 10px;">
                </div>
                <div style="display: flex; flex-direction: row; margin-bottom: 10px;">
                    <div style="flex: 0 1 160px;">
                        <div class="text-center" v-if="project.service">{{project.service.name}}</div>
                        <div class="text-center">
                            <star-rating :inline="true" :star-size="15" :read-only="true" :show-rating="false"
                                         :increment="0.01" v-model="project.score_total"></star-rating>
                        </div>
                        <div class="text-center">{{project.review_count}}
                            <small>Reviews</small>
                        </div>
                        <div class="text-center">
                            <a :href="project.url" target="_blank">公式サイト</a>
                        </div>
                    </div>
                    <div style="flex: 1 2 auto;">
                        {{project.title}}
                    </div>
                </div>

                <div class="small">{{project.description}}</div>

                <div class="text-center" style="margin-top: 20px;">
                    <router-link class="btn btn-primary" :to="{name: 'review-new', params: {id: project.id}}">
                        レビューを書く！
                    </router-link>
                </div>
            </div>

            <div v-if="is_opened_description" style="color: #666;">
                商品名：商品名があるば、その名前<br>
                コメント：各人が感じたことなど<br>
                商品：良い商品か<br>
                実行者：良い実行者か<br>
                再購買：また同じ実行者から買いたいか<br>
                総合：総合的にいい感じか<br>
                レビューの日時：レビューを書いた日<br>
                ニックネーム：レビュワーの名前<br>
            </div>
            <div class="text-center">
                <button v-if="is_opened_description" type="button" class="btn btn-link"
                        @click="is_opened_description = 0">レビュー説明を閉じる
                </button>
                <button v-else type="button" class="btn btn-link" @click="is_opened_description = 1">レビュー説明を開く</button>
            </div>

            <div v-for="review in reviews.data">
                <hr>
                <div v-if="review.product_name" style="margin-bottom: 10px; font-weight: bold;">
                    商品名：{{review.product_name}}
                </div>
                <div style="white-space: pre-wrap; margin-bottom: 10px;">{{review.comment}}</div>

                <div>
                    <small style="margin-right: 10px;">商　品:</small>
                    <star-rating :inline="true" :star-size="20" :read-only="true"
                                 v-model="review.score_product"></star-rating>
                </div>
                <div>
                    <small style="margin-right: 10px;">実行者:</small>
                    <star-rating :inline="true" :star-size="20" :read-only="true"
                                 v-model="review.score_vendor"></star-rating>
                </div>
                <div>
                    <small style="margin-right: 10px;">再購買:</small>
                    <star-rating :inline="true" :star-size="20" :read-only="true"
                                 v-model="review.score_retry"></star-rating>
                </div>
                <div>
                    <small style="margin-right: 10px;">総　合:</small>
                    <star-rating :inline="true" :star-size="20" :read-only="true"
                                 v-model="review.score_total"></star-rating>
                </div>

                <div class="text-right">{{review.updated_at}}</div>
                <div class="text-right">{{review.nickname}}</div>
            </div>

            <div v-if="reviews.total === 0">
                レビューが登録されていません。
            </div>

            <div v-else style="margin-top: 20px;">
                <div class="text-center">
                    {{reviews.to}} / {{reviews.total}} を表示中
                </div>
                <div v-if="reviews.total > reviews.to" class="text-center">
                    <button type="button" @click="loadMore()" class="btn btn-secondary">More Reviews</button>
                </div>
            </div>

            <div class="text-center" style="margin-top: 20px;">
                <router-link class="btn btn-primary" :to="{name: 'review-new', params: {id: project.id}}">
                    レビューを書く！
                </router-link>
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
                params: {
                    page: 1,
                },
                reviews: {
                    data: [],

                    from: null,
                    to: null,
                    total: null,

                    current_page: null,
                    first_page_url: null,
                    last_page_url: null,
                    next_page_url: null,
                    prev_page_url: null,
                    per_page: null,
                },
                project: {},
                project_id: this.$route.params.id,
                is_opened_description: 0,
            }
        },
        mounted() {
            this.fetchData(this.$route.params.id)
            this.getReviews()
        },
        methods: {
            async fetchData(project_id) {
                axios.get('project/' + encodeURIComponent(project_id))
                    .then(res => {
                        this.project = res.data
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            async getReviews() {
                axios.get('project/' + encodeURIComponent(this.project_id) + '/review', {params: this.params})
                    .then(res => {
                        // this.reviews = res.data


                        if (this.params.page === 1) {
                            this.reviews = res.data
                        } else {
                            const response = res.data
                            this.reviews.from = response.from
                            this.reviews.to = response.to
                            this.reviews.current_page = response.current_page
                            this.reviews.per_page = response.per_page
                            this.reviews.total = response.total

                            for (let review of res.data.data) {
                                this.reviews.data.push(review)
                            }
                        }

                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            loadMore() {
                this.params.page = this.reviews.current_page + 1
                this.getReviews()
            },
        }
    }
</script>

<style scoped>
    img {
        width: 100%;
    }
</style>
