<template>
    <section id="project-list">

        <div class="form-group" style="margin: 20px 0;">
            <select v-model="params.service_id" class="form-control" @change="fetchData()">
                <option value="">選択してください</option>
                <option v-for="service in services" :value="service.id">{{service.name}}</option>
            </select>
        </div>

        <div v-for="project in projects.data" style="margin-bottom: 20px;">

            <div v-if="project.image_url">
                <img :src="project.image_url" style="margin-bottom: 10px;">
            </div>
            <div style="font-weight: bold;margin-bottom: 20px;">{{project.title}}</div>

            <div class="text-center">
                <button type="button" class="btn btn-primary">more</button>
            </div>

        </div>

        <div v-if="projects.total === 0">
            プロジェクトが登録されていないか、検索条件にヒットしませんでした。
        </div>

        <div v-else style="margin-top: 20px;">
            <div>
                全部で {{projects.total}} 件<br>
                {{projects.from}} 件目から {{projects.to}} 件目まで表示中
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
                params: {

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
            console.log('Project Component mounted.')
            this.fetchData()
            this.getServices()
        },
        methods: {
            async fetchData() {
                axios.get('project', {params: this.params})
                    .then(res => {
                        this.projects = res.data
                        console.log(res.data)
                    })
                    .catch(e => {
                        console.error(e)
                    })
            },
            async getServices(){
                axios.get('service')
                    .then(res => {
                        this.services = res.data
                    })
                    .catch(e => {
                        console.error(e)
                    })
            }
        }
    }
</script>

<style scoped>
    img {
        width: 100%;
    }
</style>
