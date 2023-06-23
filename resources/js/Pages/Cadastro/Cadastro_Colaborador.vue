<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <h2>Colaboradores</h2>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link active fw-bold"
                        @click="irFicha()"
                        id="ficha"
                        aria-current="page"
                        href="#"
                        >Ficha</a
                    >
                </li>
                <li class="nav-item nav-atendimento">
                    <a
                        class="nav-link fw-bold"
                        id="atendimento"
                        href="#"
                        @click="irAtendimento"
                        >Atendimento</a
                    >
                </li>
            </ul>
            <div id="ficha-paciente">
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="nome_completo" class="fw-bold">Nome Completo:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="nome_completo"
                                v-model="nomeCompleto"
                            />
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="cpf" class="fw-bold">CPF:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-mask="['###.###.###-##']"
                                id="cpf"
                                v-model="cpf"
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="dataAdmissao" class="fw-bold">Data de admissão:</label>
                            <input
                                type="date"
                                class="form-control"
                                id="dataAdmissao"
                                v-model="dataAdmissao"
                            />
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="data_nascimento" class="fw-bold"
                                >Data de Nascimento:</label
                            >
                            <input
                                type="date"
                                class="form-control"
                                id="data_nascimento"
                                v-model="dataNascimento"
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="genero" class="fw-bold">Gênero:</label>
                            <select
                                class="form-control"
                                id="genero"
                                v-model="genero"
                            >
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="celular" class="fw-bold">Celular:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-mask="['(##) ####-####', '(##) #####-####']"
                                id="celular"
                                v-model="celular"
                            />
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="cep" class="fw-bold">CEP:</label>
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
                            <label for="rua" class="fw-bold">Rua:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="rua"
                                v-model="rua"
                            />
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="numero" class="fw-bold">Número:</label>
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
                            <label for="bairro" class="fw-bold">Bairro:</label>
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
                            <label for="cidade" class="fw-bold">Cidade:</label>
                            <input
                                type="text"
                                class="form-control"
                                id="cidade"
                                v-model="cidade"
                            />
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="estado" class="fw-bold">Estado:</label>
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
                        class="w-50 fw-bold btn-lg"
                        :class="buttonClass"
                    >
                        {{ buttonText }}
                    </button>
                </div>
            </div>
            <div id="atendimento-paciente" hidden>
                <div class="card">
                    <div class="py-5">
                        <div class="card w-75 mx-auto">
                            <input
                                @change="capturarArquivo"
                                type="file"
                                class="form-control"
                                id="inputGroupFile01"
                            />
                            <div class="input-group mb-3"></div>
                            <div class="pb-4 d-flex justify-content-center">
                                <button
                                    class="btn btn-primary w-50 fw-bold"
                                    @click="enviarArquivo"
                                >
                                    Enviar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid content-row">
                        <div class="row py-5">
                            <template v-for="atendimento in atendimentos">
                                <div class="col-sm-12 col-lg-6 py-2">
                                    <div class="card h-100 text-center">
                                        <i
                                            class="bi bi-file-earmark-word"
                                            style="font-size: 2rem"
                                        ></i>
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{ atendimento.nome }}
                                            </h5>
                                            <button
                                                class="btn btn-primary"
                                                @click="
                                                    baixarDocumento(
                                                        atendimento.nome,
                                                        atendimento.caminho
                                                    )
                                                "
                                            >
                                                Baixar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "../../Components/Navbar.vue";
import Swal from "sweetalert2/dist/sweetalert2.js";
import { createToast } from "mosha-vue-toastify";
import { mask } from "vue-the-mask";
import axios from "axios";
import $ from "jquery";
import "jquery-mask-plugin";

export default {
    props: {
        id: "",
    },
    components: {
        Navbar,
    },
    data() {
        return {
            atendimentos: [],
            atendimento: {
                arquivo: "",
                nome: "",
            },
            nomeCompleto: "",
            cpf: "",
            dataNascimento: "",
            dataAdmissao: "",
            genero: "",
            celular: "",
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
            return this.isEditing ? "Salvar" : "Cadastrar";
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
        baixarDocumento(nome, caminho) {
            console.log(caminho);
            axios
                .post(
                    `/download`,
                    { caminho: caminho },
                    { responseType: "blob" }
                )
                .then((response) => {
                    console.log(response);
                    const href = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = href;
                    link.setAttribute("download", nome); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(href);
                });
        },
        capturarArquivo(event) {
            this.atendimento.arquivo = event.target.files[0];
        },
        async enviarArquivo() {
            var form = "";
            var profissional = JSON.parse(localStorage.getItem("profissional"));
            form = new FormData();
            form.append("documento", this.atendimento.arquivo);
            form.append("nome", this.atendimento.nome);
            form.append("colaborador_id", this.id);
            form.append("profissional_id", profissional.profissional_id);

            await axios
                .post("/upload", form, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    console.log(response);
                    if (response.data != "") {
                        this.fetchAtendimentos();
                    }
                });
        },
        irAtendimento() {
            $("#ficha-paciente").attr("hidden", true);
            $("#atendimento-paciente").attr("hidden", false);
            $("#ficha").removeClass("active");
            $("#atendimento").addClass("active");
        },
        irFicha() {
            $("#ficha-paciente").attr("hidden", false);
            $("#atendimento-paciente").attr("hidden", true);
            $("#ficha").addClass("active");
            $("#atendimento").removeClass("active");
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
                .post("/adicionar/colaborador", {
                    nome_completo: this.nomeCompleto,
                    cpf: this.cpf,
                    data_nascimento: this.dataNascimento,
                    dataAdmissao: this.dataAdmissao,
                    genero: this.genero,
                    celular: this.celular,
                    cep: this.cep,
                    rua: this.rua,
                    numero: this.numero,
                    bairro: this.bairro,
                    cidade: this.cidade,
                    estado: this.estado,
                })
                .catch((response) => {
                    createToast("Erro ao inserir colaborador!", {
                        type: "danger",
                        showIcon: "true",
                        timeout: 2500,
                    });
                })
                .then((response) => {
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Colaborador inserido com sucesso!",
                            true
                        );
                    } else {
                        createToast("Erro ao inserir colaborador!", {
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
                .put(`/atualizar/colaborador/${this.id}`, {
                    nome_completo: this.nomeCompleto,
                    cpf: this.cpf,
                    data_nascimento: this.dataNascimento,
                    data_admissao: this.dataAdmissao,
                    genero: this.genero,
                    celular: this.celular,
                    cep: this.cep,
                    rua: this.rua,
                    numero: this.numero,
                    bairro: this.bairro,
                    cidade: this.cidade,
                    estado: this.estado,
                })
                .catch((response) => {
                    createToast("Erro ao atualizar colaborador!", {
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
                            "Colaborador atualizado com sucesso!",
                            true
                        );
                    } else {
                        createToast("Erro ao atualizar colaborador!", {
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
        async fetchColaborador() {
            this.modalLoading();
            await axios
                .post("/buscar/colaborador/" + this.id)
                .then((response) => {
                    console.log(response);
                    this.nomeCompleto = response.data.nome_completo;
                    this.cpf = response.data.cpf;
                    this.dataNascimento = response.data.data_nascimento;
                    this.dataAdmissao = response.data.data_admissao;
                    this.genero = response.data.genero;
                    this.celular = response.data.celular;
                    this.cep = response.data.cep;
                    this.rua = response.data.rua;
                    this.numero = response.data.numero;
                    this.bairro = response.data.bairro;
                    this.cidade = response.data.cidade;
                    this.estado = response.data.estado;

                    Swal.close();
                });
        },
        async fetchAtendimentos() {
            await axios
                .get(`/atendimentos/${this.id}`)
                .then((response) => {
                    console.log(response);
                    const documents = response.data;
                    this.atendimentos = documents;
                })
                .catch((error) => {
                    // Handle any errors that occur during the request
                    console.error(error);
                });
        },
    },
    mounted() {
        if (this.id != undefined) {
            this.isEditing = true;
            this.fetchColaborador();
            this.fetchAtendimentos();
        }
        if (!this.isEditing) {
            $(".nav-atendimento").addClass("d-none");
        }
    },
};
</script>
<style>
@import "bootstrap/dist/css/bootstrap.css";
@import "sweetalert2/dist/sweetalert2.min.css";
@import "mosha-vue-toastify/dist/style.css";
</style>
