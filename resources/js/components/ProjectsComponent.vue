<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row card-header">
                        <h3>Projects Details</h3>
                        <a href="/tasks/create" class="btn btn-outline-success float-right ml-auto mb-1">Add Task</a>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['project'],

    data() {
        return {
            tasks: [],
        }
    },
    methods: {
        getProjectTasks() {
            axios.get('/api/project-tasks/' + this.project.id ).then(
                ({data}) => {
                    this.tasks = data.data;
                }
            )
        },
    },
    mounted() {
        this.getProjectTasks();
    }
}
</script>
