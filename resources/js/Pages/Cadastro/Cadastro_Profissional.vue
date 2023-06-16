<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <h2>Cadastro de profissionais</h2>
            <form>
                <div class="form-group">
                    <label for="nome_completo">Nome Completo:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome_completo"
                        v-model="nome"
                    />
                </div>
                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="cpf"
                        v-model="cpf"
                    />
                </div>
                <div class="form-group">
                    <label for="cpf">CRM:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="crm"
                        v-model="crm"
                    />
                </div>
                <div class="form-group">
                    <label for="cpf">E-mail:</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        v-model="email"
                    />
                </div>
                <div class="form-group">
                    <label for="cpf">Senha:</label>
                    <input
                        type="password"
                        class="form-control"
                        id="senha"
                        v-model="senha"
                    />
                </div>
                <button type="submit" @click="submitForm" :class="buttonClass">
                    {{ buttonText }}
                </button>
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
            nome: "",
            cpf: "",
            crm: "",
            isEditing: false,
        };
    },
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
        createForm() {
            event.preventDefault();
            axios
                .post("/adicionar/profissional", {
                    nome: this.nome,
                    cpf: this.cpf,
                    crm: this.crm,
                })
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu ao inserir o profissional."
                    );
                })
                .then((response) => {
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Profissional inserido com sucesso!",
                            true
                        );
                    } else {
                        this.exibirModal(
                            "error",
                            "Ocorreu um erro ao atualizar o profissional."
                        );
                    }
                });
        },
        editForm() {
            event.preventDefault();
            axios
                .put(`/atualizar/profissional/${this.id}`, {
                    nome: this.nome,
                    cpf: this.cpf,
                    crm: this.crm,
                })
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu um erro ao atualizar o profissional."
                    );
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Profissional atualizado com sucesso!",
                            true
                        );
                    } else {
                        this.exibirModal(
                            "error",
                            "Ocorreu um erro ao atualizar o profissional."
                        );
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
        async fetchProfissional() {
            this.modalLoading();
            await axios
                .get("/buscar/profissional/" + this.id)
                .then((response) => {
                    this.nome = response.data.nome;
                    this.cpf = response.data.cpf;
                    this.crm = response.data.crm;
                    Swal.close();
                });
        },
    },
    mounted() {
        if (this.id != undefined) {
            this.isEditing = true;
            this.fetchProfissional();
        }
        $("#cpf").mask("000.000.000-00");
        $("#crm").mask("00000");
    },
};
</script>
<style>
@import "sweetalert2/dist/sweetalert2.min.css";
@import "bootstrap/dist/css/bootstrap.css";
</style>
