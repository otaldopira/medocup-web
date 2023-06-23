<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <div class="mb-3">
                <h2>Empresas</h2>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="nome_fantasia" >Nome Fantasia:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nome_fantasia"
                            v-model="nome_fantasia"
                        />
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="cnpj">CNPJ:</label>
                        <input
                            type="text"
                            id="cnpj"
                            class="form-control"
                            v-model="cnpj"
                            v-mask="'##.###.###/####-##'"
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="telefone">Telefone:</label>
                        <input
                            type="text"
                            id="telefone"
                            class="form-control"
                            v-model="telefone"
                            v-mask="['(##) ####-####', '(##) #####-####']"
                        />
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="cep">CEP:</label>
                        <input
                            type="text"
                            v-mask="'#####-###'"
                            class="form-control"
                            @keyup="buscarCep()"
                            id="cep"
                            v-model="cep"
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="rua">Rua:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="rua"
                            v-model="rua"
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="numero">Número:</label>
                        <input
                            type="number"
                            class="form-control"
                            id="numero"
                            v-model="numero"
                        />
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="bairro">Bairro:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="bairro"
                            v-model="bairro"
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="cidade">Cidade:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="cidade"
                            v-model="cidade"
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="fw-bold" for="estado">Estado:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="estado"
                            v-mask="'AA'"
                            v-model="estado"
                        />
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button
                    type="submit"
                    @click="submitForm"
                    :class="buttonClass"
                    class="w-50 btn-lg fw-bold"
                >
                    {{ buttonText }}
                </button>
            </div>
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
            telefone: "",
            cep: "",
            rua: "",
            numero: "",
            bairro: "",
            cidade: "",
            estado: "",
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
        async buscarCep() {
            console.log(this.cep.length);
            if (this.cep.length == 9) {
                await axios
                    .get(`https://viacep.com.br/ws/${this.cep}/json/`)
                    .then((response) => {
                        if (response.status === 200) {
                            console.log(response);
                            this.rua = response.data.logradouro;
                            this.numero = response.data.numero;
                            this.bairro = response.data.bairro;
                            this.cidade = response.data.localidade;
                            this.estado = response.data.uf;
                        }
                    });
            }
        },
        submitForm() {
            if (this.isEditing) {
                this.editForm(); // Chama a função para editar
            } else {
                this.createForm(); // Chama a função para cadastrar
            }
        },
        async createForm() {
            event.preventDefault();
            await axios
                .post("/adicionar/empresas", {
                    nome_fantasia: this.nome_fantasia,
                    cnpj: this.cnpj,
                    telefone: this.telefone,
                    cep: this.cep,
                    rua: this.rua,
                    numero: this.numero,
                    bairro: this.bairro,
                    cidade: this.cidade,
                    estado: this.estado,
                })
                .catch((response) => {
                    createToast("Erro ao inserir a empresa!", {
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
                            "Empresa inserida com sucesso!",
                            true
                        );
                    } else {
                        createToast("Erro ao inserir a empresa!", {
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
                    telefone: this.telefone,
                    cep: this.cep,
                    rua: this.rua,
                    numero: this.numero,
                    bairro: this.bairro,
                    cidade: this.cidade,
                    estado: this.estado,
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
                this.telefone = response.data.telefone;
                this.cep = response.data.cep;
                this.rua = response.data.rua;
                this.numero = response.data.numero;
                this.bairro = response.data.bairro;
                this.cidade = response.data.cidade;
                this.estado = response.data.estado;
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
