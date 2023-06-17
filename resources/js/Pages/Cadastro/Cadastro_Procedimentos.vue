<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <div class="mb-3">
                <h2>Procedimentos</h2>
            </div>
            <form>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        v-model="nome"
                    />
                </div>
                <div class="form-group">
                    <label for="tempo">Tempo:</label>
                    <input
                        type="text"
                        id="tempo"
                        class="form-control"
                        v-model="tempo"
                        v-mask="'###'"
                        placeholder="Minutos"
                    />
                </div>
                <div class="form-group">
                    <label for="valor">Valor:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"
                                >R$</span
                            >
                        </div>
                        <input
                            id="valor"
                            type="text"
                            v-money="money"
                            class="form-control"
                            v-model="valor"
                            required
                        />
                    </div>
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
import { VMoney } from "v-money";
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
            nome: "",
            tempo: "",
            valor: "",
            money: {
                decimal: ",",
                thousands: ".",
                precision: 2,
                masked: false,
            },
            isEditing: false,
        };
    },
    directives: { mask, money: VMoney },
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
        async createForm() {
            event.preventDefault();
            axios
                .post("/adicionar/procedimento", {
                    nome: this.nome,
                    tempo: this.tempo,
                    valor: this.valor,
                })
                .catch((response) => {
                    createToast("Erro ao inserir procedimento!", {
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
                            "Procedimento inserido!",
                            true
                        );
                    } else {
                        createToast("Erro ao inserir procedimento!", {
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
                .put(`/atualizar/procedimento`, {
                    procedimento_id: this.id,
                    nome: this.nome,
                    tempo: this.tempo,
                    valor: this.valor,
                })
                .catch((response) => {
                    createToast("Erro ao editar a procedimento!", {
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
                            "Procedimento atualizado com sucesso!",
                            true
                        );
                    } else {
                        createToast("Erro ao editar a procedimento!", {
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
        async fetchProcedimento() {
            this.modalLoading();
            await axios.get("/buscar/procedimento/" + this.id).then((response) => {
                this.nome = response.data.nome;
                this.tempo = response.data.tempo;
                this.valor = response.data.valor;
                Swal.close();
            });
        },
    },
    mounted() {
        if (this.id != undefined) {
            this.isEditing = true;
            this.fetchProcedimento();
        }
    },
};
</script>
<style>
@import "sweetalert2/dist/sweetalert2.min.css";
@import "bootstrap/dist/css/bootstrap.css";
@import "mosha-vue-toastify/dist/style.css";
</style>
