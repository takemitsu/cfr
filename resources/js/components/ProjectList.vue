<template>
    <section id="project-list">

        <transition name="form">
            <div class="row justify-content-center">

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" style="margin: 20px 0;" v-if="isOpenedSearch">
                    <div class="form-group">
                        <label>Select Servicer</label>
                        <select v-model="params.service_id" class="form-control" @change="changeService()">
                            <option value="">選択してください</option>
                            <option v-for="service in services" :value="service.id">{{service.name}}</option>
                        </select>
                        <small class="text-muted">サービサーの追加については個別にご連絡ください。</small>
                    </div>
                    <div class="form-group">
                        <label>Input Project Name for Search</label>
                        <input type="text" v-model="params.search" class="form-control" placeholder="Project Name">
                        <small class="text-muted">部分一致ですが、全角半角/小文字/大文字などが完全でないと一部でもヒットしない可能性があります。予めご了承ください。</small>
                    </div>
                    <div class="btn-group">
                        <button type="reset" class="btn btn-link" @click="resetParams()">Reset</button>
                        <button type="button" class="btn btn-primary" @click="changeService">Search</button>
                    </div>
                </div>
            </div>
        </transition>
        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 20px;">
                <button v-if="isOpenedSearch" type="button" class="btn btn-secondary btn-block"
                        @click="isOpenedSearch = 0">
                    Close Search
                </button>
                <button v-else type="button" class="btn btn-secondary btn-block" @click="isOpenedSearch = 1">Open Search
                </button>
            </div>
        </div>


        <div class="row">
            <div v-for="project in projects.data" class="col-xl-3 col-lg-4 col-md-6 col-sm-12"
                 style="margin-bottom: 30px;">

                <div v-if="project.image_url">
                    <img :src="project.image_url" style="margin-bottom: 10px;">
                </div>

                <div style="display: flex; flex-direction: row; margin-bottom: 10px;">
                    <div style="flex: 0 1 160px;">
                        <div class="text-center">{{project.service.name}}</div>
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

                <div class="text-center">
                    <router-link class="btn btn-primary" :to="{name: 'project-detail', params: {id: project.id}}">
                        Reviews
                    </router-link>
                </div>
            </div>
        </div>

        <div v-if="projects.total === 0">
            プロジェクトが登録されていないか、検索条件にヒットしませんでした。
        </div>

        <div v-else style="margin-top: 20px;">
            <div class="text-center">
                {{projects.to}} / {{projects.total}} を表示中
            </div>

            <div v-if="projects.total > projects.to" class="text-center">
                <button type="button" @click="loadMore()" class="btn btn-secondary">More Projects</button>
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
                show: 1,
                isOpenedSearch: 0,
                params: {
                    page: 1,
                    service_id: null,
                    search: '',
                },
                projects: {
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
                services: [],
            }
        },
        mounted() {
            this.fetchData()
            this.getServices()
        },
        methods: {
            async fetchData() {
                axios.get('project', {params: this.params})
                    .then(res => {
                        if (this.params.page === 1) {
                            this.projects = res.data
                        } else {
                            const response = res.data
                            this.projects.from = response.from
                            this.projects.to = response.to
                            this.projects.current_page = response.current_page
                            this.projects.per_page = response.per_page
                            this.projects.total = response.total

                            for (let project of res.data.data) {
                                this.projects.data.push(project)
                            }
                        }
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            async getServices() {
                axios.get('service')
                    .then(res => {
                        this.services = res.data
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            loadMore() {
                this.params.page = this.projects.current_page + 1
                this.fetchData()
            },
            changeService() {
                this.params.page = 1
                this.fetchData()
            },
            resetParams: function () {
                this.params.page = 1
                this.params.service_id = null
                this.params.search = ''
                this.fetchData()
            }
        }
    }
</script>

<style lang="scss" scoped>
    img {
        width: 100%;
    }

    .form-enter-active, .form-leave-active {
        transition: opacity .5s;
    }

    .form-enter, .form-leave-to {
        opacity: 0;
    }
</style>
