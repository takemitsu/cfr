<template>
    <section id="project-detail">

        <div v-if="project" style="margin-bottom: 20px;">

            <div v-if="project.image_url">
                <img :src="project.image_url" style="margin-bottom: 10px;">
            </div>
            <div style="font-weight: bold;margin-bottom: 20px;">{{project.title}}</div>

            <div class="small">{{project.description}}</div>

            <div class="text-center" style="margin-top: 20px;">
                <router-link class="btn btn-primary" :to="{name: 'review-new', params: {id: project.id}}">New Review</router-link>
            </div>
        </div>

        <div v-for="review in reviews.data">
            <hr>
            <div v-if="review.product_name" style="margin-bottom: 10px; font-weight: bold;">{{review.product_name}}</div>
            <div style="white-space: pre-wrap; margin-bottom: 10px;">{{review.comment}}</div>
            <div><small>商品の評価:</small> {{review.score_product}}</div>
            <div><small>実行者評価:</small> {{review.score_vendor}}</div>
            <div><small>再購買意欲:</small> {{review.score_retry}}</div>
            <div><small>総合的評価:</small> {{review.score_total}}</div>
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
    export default {
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
