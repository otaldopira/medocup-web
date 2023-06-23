<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <h2>Profissionais</h2>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link fw-bold"
                        :class="{ active: activeTab === 'ficha' }"
                        @click="changeTab('ficha')"
                        id="ficha"
                        href="#"
                        >Ficha</a
                    >
                </li>
                <li
                    class="nav-item nav-Autenticacao"
                    v-if="!url.match('/cadastro/profissional')"
                >
                    <a
                        class="nav-link fw-bold"
                        :class="{ active: activeTab === 'autenticacao' }"
                        @click="changeTab('autenticacao')"
                        id="Autenticacao"
                        href="#"
                        >Autenticação</a
                    >
                </li>
            </ul>
            <template v-if="activeTab === 'ficha'">
                <div>
                    <div class="form-group my-2">
                        <label class="fw-bold" for="nome_completo">Nome Completo:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nome_completo"
                            v-model="nome"
                        />
                    </div>
                    <div class="form-group my-2">
                        <label class="fw-bold" for="cpf">CPF:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="cpf"
                            v-model="cpf"
                            v-mask="['###.###.###-##']"
                        />
                    </div>
                    <div class="form-group my-2">
                        <label class="fw-bold" for="cpf">CRM:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="crm"
                            v-model="crm"
                        />
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button
                            type="submit"
                            @click="submitForm"
                            class="w-50 fw-bold btn-lg"
                            :class="buttonClass"
                        >
                            {{ buttonText }}
                        </button>
                    </div>
                </div>
            </template>
            <template
                v-if="
                    activeTab === 'autenticacao' &&
                    !url.match('/cadastro/profissional')
                "
            >
                <div>
                    <div class="form-group my-2">
                        <label class="fw-bold" for="cpf">E-mail:</label>
                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            v-model="email"
                        />
                    </div>
                    <div class="form-group my-2">
                        <label class="fw-bold" for="cpf">Senha:</label>
                        <input
                            type="password"
                            class="form-control"
                            id="senha"
                            v-model="senha"
                        />
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button
                            type="submit"
                            @click="submitAutenticacao()"
                            class="w-50 fw-bold btn-lg"
                            :class="buttonClass"
                        >
                            {{ buttonText }}
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
import Navbar from "../../Components/Navbar.vue";
import Swal from "sweetalert2/dist/sweetalert2.js";
import { createToast } from "mosha-vue-toastify";
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
    directives: { mask },
    data() {
        return {
            activeTab: "ficha",
            nome: "",
            cpf: "",
            crm: "",
            email: "",
            senha: "",
            isEditing: false,
            url: window.location.href,
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
            return this.isEditing ? "Salvar" : "Cadastrar";
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
        async submitAutenticacao() {
            event.preventDefault();
            await axios
                .post(`/autenticacao/profissional/${this.id}`, {
                    email: this.email,
                    senha: this.senha,
                })
                .catch((response) => {
                    createToast("Erro ao inserir o auntenticação!", {
                        type: "danger",
                        showIcon: true,
                        timeout: 2500,
                    });
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Aunteticação inserida com sucesso!",
                            true
                        );
                    } else {
                        createToast("Erro ao inserir o auntenticação!", {
                            type: "danger",
                            showIcon: true,
                            timeout: 2500,
                        });
                    }
                });
        },
        async createForm() {
            event.preventDefault();
            await axios
                .post("/adicionar/profissional", {
                    nome: this.nome,
                    cpf: this.cpf,
                    crm: this.crm,
                })
                .catch((response) => {
                    createToast("Erro ao inserir o profissional!", {
                        type: "danger",
                        showIcon: true,
                        timeout: 2500,
                    });
                })
                .then((response) => {
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Profissional inserido com sucesso!",
                            true
                        );
                    } else {
                        createToast("Erro ao inserir o profissional!", {
                            type: "danger",
                            showIcon: true,
                            timeout: 2500,
                        });
                    }
                });
        },
        async editForm() {
            event.preventDefault();
            await axios
                .put(`/atualizar/profissional/${this.id}`, {
                    nome: this.nome,
                    cpf: this.cpf,
                    crm: this.crm,
                })
                .catch((response) => {
                    createToast("Erro ao atualizar o profissional!", {
                        type: "danger",
                        showIcon: true,
                        timeout: 2500,
                    });
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
                        createToast("Erro ao atualizar o profissional!", {
                            type: "danger",
                            showIcon: true,
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
        async fetchProfissional() {
            this.modalLoading();
            await axios
                .get("/buscar/profissional/" + this.id)
                .then((response) => {
                    this.nome = response.data.nome;
                    this.cpf = response.data.cpf;
                    this.crm = response.data.crm;
                    this.email = response.data.email;
                    Swal.close();
                });
        },
        changeTab(tab) {
            this.activeTab = tab;
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
@import "mosha-vue-toastify/dist/style.css";
</style>
