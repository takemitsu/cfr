<template>
    <section id="project-detail">

        <div v-if="project" style="margin-bottom: 20px;">

            <div v-if="project.image_url">
                <img :src="project.image_url" style="margin-bottom: 10px;">
            </div>
            <div style="display: flex; flex-direction: row; margin-bottom: 10px;">
                <div style="flex: 0 1 160px;">
                    <div class="text-center" v-if="project.service">{{project.service.name}}</div>
                    <div class="text-center">
                        <star-rating :inline="true" :star-size="15" :read-only="true" :show-rating="false" :increment="0.01" v-model="project.score_total"></star-rating>
                    </div>
                    <div class="text-center">{{project.review_count}} <small>Reviews</small></div>
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
                <router-link class="btn btn-primary" :to="{name: 'review-new', params: {id: project.id}}">New Review</router-link>
            </div>
        </div>

        <div v-for="review in reviews.data">
            <hr>
            <div v-if="review.product_name" style="margin-bottom: 10px; font-weight: bold;">{{review.product_name}}</div>
            <div style="white-space: pre-wrap; margin-bottom: 10px;">{{review.comment}}</div>

            <div>
                <small style="margin-right: 10px;">商　品:</small>
                <star-rating :inline="true" :star-size="20" :read-only="true" v-model="review.score_product"></star-rating>
            </div>
            <div>
                <small style="margin-right: 10px;">実行者:</small>
                <star-rating :inline="true" :star-size="20" :read-only="true" v-model="review.score_vendor"></star-rating>
            </div>
            <div>
                <small style="margin-right: 10px;">再購買:</small>
                <star-rating :inline="true" :star-size="20" :read-only="true" v-model="review.score_retry"></star-rating>
            </div>
            <div>
                <small style="margin-right: 10px;">総　合:</small>
                <star-rating :inline="true" :star-size="20" :read-only="true" v-model="review.score_total"></star-rating>
            </div>

            <div class="text-right">{{review.updated_at}}</div>
            <div class="text-right">{{review.nickname}}</div>
        </div>

        <div v-if="reviews.total === 0">
            レビューが登録されていません。
        </div>

        <div v-else style="margin-top: 20px;">
            <div>
                全部で {{reviews.total}} 件<br>
                {{reviews.from}} 件目から {{reviews.to}} 件目まで表示中
            </div>

            <!-- TODO: Pagination 計算して表示する (このままだと vue router ではなく laravel api につながる)
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item" v-if="projects.first_page_url"><a class="page-link" :href="projects.first_page_url">first</a></li>
                    <li class="page-item" v-if="projects.prev_page_url"><a class="page-link" :href="projects.prev_page_url">prev</a></li>
                    <li class="page-item" v-if="projects.next_page_url"><a class="page-link" :href="projects.next_page_url">next</a></li>
                    <li class="page-item" v-if="projects.last_page_url"><a class="page-link" :href="projects.last_page_url">last</a></li>
                </ul>
            </nav>
            -->

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
            }
        },
        mounted() {
            this.fetchData(this.$route.params.id)
            this.getReviews(this.$route.params.id)
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
            async getReviews(project_id) {
                axios.get('project/' + encodeURIComponent(project_id) + '/review')
                    .then(res => {
                        this.reviews = res.data
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
        }
    }
</script>

<style scoped>
    img {
        width: 100%;
    }
</style>
