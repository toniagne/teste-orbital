<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="card-title">Gestão de Números</h3>
                </div>
                <div class="col-sm-6 text-right">



                        <a  class="btn btn-sm btn-primary" href="/dashboard">
                           IR PARA O DASHBOARD
                        </a>

                        <a  class="btn btn-sm btn-primary" @click="newModal">
                            NOVO NÚMERO
                        </a>

                </div>
                <div class="col-12">

                    <div class="card">
                        <div class="card-header justify-content-between">

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Valor</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="manager in managers" :key="manager.id">

                                    <td>{{manager.id}}</td>
                                    <td>{{manager.title}}</td>
                                    <td>{{manager.value}}</td>
                                    <!-- <td><img v-bind:src="'/' + product.photo" width="100" alt="product"></td> -->
                                    <td>

                                        <a href="#" class="btn" @click="editModal(manager)">
                                           Editar
                                        </a>
                                        /
                                        <a href="#" class="btn" @click="deleteManager(manager.id)">
                                            Apagar
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="!editmode">Criar um novo número</h5>
                            <h5 class="modal-title" v-show="editmode">Editar Registro</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editmode ? updateManager() : createManager()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input v-model="form.title" type="text" name="title"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group">
                                    <label>Quantidade</label>
                                    <input v-model="form.value" type="number" name="value"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('value') }">
                                    <has-error :form="form" field="price"></has-error>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Atualizar</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

    export default {
        components: {
        },
        data () {
            return {
                editmode: false,
                managers : {},
                form: new Form({
                    id : '',
                    title : '',
                    value: ''
                }),
            }
        },
        methods: {

            getResults(page = 1) {

                this.$Progress.start();

                axios.get('../api/v1/managers?page=' + page).then(({ data }) => (this.managers = data.data));

                this.$Progress.finish();
            },
            loadmanagers(){

                // if(this.$gate.isAdmin()){
                axios.get("../api/v1/managers").then(({ data }) => (this.managers = data.data));
                // }
            },
            editModal(manager){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(manager);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            createManager(){
                this.$Progress.start();

                this.form.post('../api/v1/managers')
                    .then((data)=>{
                        if(data.data.success){
                            $('#addNew').modal('hide');

                            Toast.fire({
                                icon: 'success',
                                title: data.data.message
                            });
                            this.$Progress.finish();
                            this.loadmanagers();

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Some error occured! Please try again'
                            });

                            this.$Progress.failed();
                        }
                    })
                    .catch(()=>{

                        Toast.fire({
                            icon: 'error',
                            title: 'Some error occured! Please try again'
                        });
                    })
            },
            updateManager(){
                this.$Progress.start();
                this.form.put('../api/v1/managers/'+this.form.id)
                    .then((response) => {
                        // success
                        $('#addNew').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');

                        this.loadmanagers();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

            },
            deleteManager(id){
                Swal.fire({
                    title: 'Vocẽ tem certeza ?',
                    text: "Esta é uma ação ireverssível",
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, apagar este registro'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        this.form.delete('../api/v1/managers/'+id).then(()=>{
                            Swal.fire(
                                'Apagado!',
                                'Seu registro foi apado com suscesso.',
                                'success'
                            );
                            // Fire.$emit('AfterCreate');
                            this.loadmanagers();
                        }).catch((data)=> {
                            Swal.fire("Erro!", data.message, "warning");
                        });
                    }
                })
            },

        },
        mounted() {

        },
        created() {
            this.$Progress.start();
            this.loadmanagers();
            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
            filteredItems() {
                return this.autocompleteItems.filter(i => {
                    return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
                });
            },
        },
    }
</script>
