<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <h2>Cadastro de Colaboradores</h2>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        @click="irFicha()"
                        id="ficha"
                        aria-current="page"
                        href="#"
                        >Ficha</a
                    >
                </li>
                <li class="nav-item nav-atendimento">
                    <a
                        class="nav-link"
                        id="atendimento"
                        href="#"
                        @click="irAtendimento"
                        >Atendimento</a
                    >
                </li>
            </ul>
            <div id="ficha-paciente">
                <form>
                    <div class="form-group">
                        <label for="nome_completo">Nome Completo:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="nome_completo"
                            v-model="nomeCompleto"
                        />
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input
                            type="text"
                            class="form-control"
                            v-mask="['###.###.###-##']"
                            id="cpf"
                            v-model="cpf"
                        />
                    </div>
                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento:</label>
                        <input
                            type="date"
                            class="form-control"
                            id="data_nascimento"
                            v-model="dataNascimento"
                        />
                    </div>
                    <div class="form-group">
                        <label for="genero">Gênero:</label>
                        <select class="form-control" id="genero" v-model="genero">
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input
                            type="text"
                            class="form-control"
                            v-mask="['(##) ####-####', '(##) #####-####']"
                            id="celular"
                            v-model="celular"
                        />
                    </div>
                    <button type="submit" @click="submitForm" :class="buttonClass">
                        {{ buttonText }}
                    </button>
                </form>
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
                                    class="btn btn-primary w-50"
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
            genero: "",
            celular: "",
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
        enviarArquivo() {
            var form = "";
            var profissional = JSON.parse(localStorage.getItem("profissional"));
            form = new FormData();
            form.append("documento", this.atendimento.arquivo);
            form.append("nome", this.atendimento.nome);
            form.append("colaborador_id", this.id);
            form.append("profissional_id", profissional.profissional_id);

            axios
                .post("/upload", form, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
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
        createForm() {
            event.preventDefault();
            axios
                .post("/adicionar/colaborador", {
                    nome_completo: this.nomeCompleto,
                    cpf: this.cpf,
                    data_nascimento: this.dataNascimento,
                    genero: this.genero,
                    celular: this.celular,
                })
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu ao inserir o colaborador."
                    );
                })
                .then((response) => {
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Colaborador inserido com sucesso!",
                            true
                        );
                    }
                });
        },
        editForm() {
            event.preventDefault();
            axios
                .put(`/atualizar/colaborador/${this.id}`, {
                    nome_completo: this.nomeCompleto,
                    cpf: this.cpf,
                    data_nascimento: this.dataNascimento,
                    genero: this.genero,
                    celular: this.celular,
                })
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu um erro ao atualizar o colaborador."
                    );
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code == 200) {
                        this.exibirModal(
                            "success",
                            "Colaborador atualizado com sucesso!",
                            true
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
        async fetchColaborador() {
            this.modalLoading();
            await axios
                .post("/buscar/colaborador/" + this.id)
                .then((response) => {
                    this.nomeCompleto = response.data.nome_completo;
                    this.cpf = response.data.cpf;
                    this.dataNascimento = response.data.data_nascimento;
                    this.genero = response.data.genero;
                    this.celular = response.data.celular;
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
</style>
