<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <div class="mb-3">
                <h2>Empresas</h2>
            </div>
            <form>
                <div class="form-group">
                    <label for="nome_fantasia">Nome Fantasia:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome_fantasia"
                        v-model="nome_fantasia"
                    />
                </div>
                <div class="form-group">
                    <label for="cnpj">CNPJ:</label>
                    <input
                        type="text"
                        id="cnpj"
                        class="form-control"
                        v-model="cnpj"
                        v-mask="'##.###.###/####-##'"
                    />
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button
                        type="submit"
                        @click="submitForm"
                        :class="buttonClass"
                        class="w-50"
                    >
                        {{ buttonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Navbar from "../../Components/Navbar.vue";
import Swal from "sweetalert2/dist/sweetalert2.js";
import axios from "axios";
import $ from "jquery";
import { mask } from "vue-the-mask";
import { createToast } from "mosha-vue-toastify";
import "jquery-mask-plugin";

export default {
    props: {
        id: null,
    },
    components: {
        Navbar,
    },
    data() {
        return {
            nome_fantasia: "",
            cnpj: "",
            isEditing: false,
        };
    },
    directives: { mask },
    computed: {
        // Classe do botão com base no modo (Editar ou Cadastrar)
        buttonClass() {
            return this.isEditing
                ? "btn btn-primary mt-3"
                : "btn btn-success mt-3";
        },
        // Texto do botão com base no modo (Editar ou Cadastrar)
        buttonText() {
            return this.isEditing ? "Editar" : "Cadastrar";
        },
    },
    methods: {
        submitForm() {
            if (this.isEditing) {
                this.editForm(); // Chama a função para editar
            } else {
                this.createForm(); // Chama a função para cadastrar
            }
        },
        async createForm() {
            event.preventDefault();
            axios
                .post("/adicionar/empresas", {
                    nome_fantasia: this.nome_fantasia,
                    cnpj: this.cnpj,
                })
                .catch((response) => {
                    createToast("Ocorreu um erro ao inserir a empresa!", {
                        type: "danger",
                        showIcon: true,
                        timeout: 2500,
                    });
                })
                .then((response) => {
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "empresa inserido com sucesso!",
                            true
                        );
                    } else {
                        createToast("Ocorreu um erro ao inserir a empresa!", {
                            type: "danger",
                            showIcon: "true",
                            timeout: 2500,
                        });
                    }
                });
        },
        async editForm() {
            event.preventDefault();
            await axios
                .put(`/atualizar/empresa/${this.id}`, {
                    nome_fantasia: this.nome_fantasia,
                    cnpj: this.cnpj,
                })
                .catch((response) => {
                    createToast("Ocorreu um erro ao editar a empresa!", {
                        type: "danger",
                        showIcon: "true",
                        timeout: 2500,
                    });
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Empresa atualizada com sucesso!",
                            true
                        );
                    } else {
                        createToast("Ocorreu um erro ao editar a empresa!", {
                            type: "danger",
                            showIcon: "true",
                            timeout: 2500,
                        });
                    }
                });
        },
        exibirModal(tipo, mensagem, fecharHistorico = false) {
            Swal.fire({
                icon: tipo,
                title: mensagem,
                showConfirmButton: false,
                timer: 1500,
                willClose: () => {
                    if (fecharHistorico) {
                        window.history.back();
                    }
                },
            });
        },
        modalLoading() {
            Swal.fire({
                title: "Aguarde",
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        },
        async fetchEmpresa() {
            this.modalLoading();
            await axios.get("/buscar/empresa/" + this.id).then((response) => {
                this.nome_fantasia = response.data.nome_fantasia;
                this.cnpj = response.data.cnpj;
                Swal.close();
            });
        },
    },
    mounted() {
        if (this.id != undefined) {
            this.isEditing = true;
            this.fetchEmpresa();
        }
    },
};
</script>
<style>
@import "sweetalert2/dist/sweetalert2.min.css";
@import "bootstrap/dist/css/bootstrap.css";
@import "mosha-vue-toastify/dist/style.css";
</style>
