<template>
    <section id="project-list">
        <div>
            {{projects}}
        </div>
    </section>
</template>

<script>
    export default {
        data() {
            return {
                params: {

                },
                projects: {},
            }
        },
        mounted() {
            console.log('Project Component mounted.')
            this.fetchData()
        },
        methods: {
            async fetchData() {
                axios.get('project', this.params)
                    .then(res => {
                        this.projects = res.data
                        console.log(res.data)
                    })
                    .catch(e => {
                        console.error(e)
                    })
            }
        }
    }
</script>
