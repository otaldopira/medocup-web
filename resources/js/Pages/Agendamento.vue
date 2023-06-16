<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg my-5 p-4 w-75 mx-auto">
            <h2 class="mb-4">Agendamento</h2>
            <form @submit.prevent="submitForm">
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="data">Data:</label>
                            <input
                                type="date"
                                id="data"
                                class="form-control"
                                :value="formattedDate"
                                required
                                disabled
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="hora">Hora:</label>
                            <input
                                type="time"
                                id="hora"
                                class="form-control"
                                :value="formattedTime"
                                required
                                disabled
                            />
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="search-status">Status:</label>
                            <select
                                data-placeholder="Selecione o status"
                                class="form-control"
                                id="search-status"
                                v-model="form.status"
                                required
                            >
                                <template
                                    v-for="(status, index) in this.status"
                                    :key="index"
                                >
                                    <option
                                        :value="status.id"
                                        v
                                        :selected="
                                            status.id ===
                                            this.agendamento?.status_id
                                        "
                                    >
                                        {{ status.status }}
                                    </option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="search-colaborador">Colaborador:</label>
                            <select
                                data-placeholder="Selecione um colaborador"
                                class="form-control"
                                id="search-colaborador"
                                v-model="form.colaborador"
                                required
                            >
                                <template
                                    v-for="(colaborador, index) in this
                                        .colaboradores"
                                    :key="index"
                                >
                                    <option
                                        :value="colaborador.colaborador_id"
                                        :selected="
                                            colaborador.colaborador_id ===
                                            this.agendamento?.colaborador_id
                                        "
                                    >
                                        {{ colaborador.nome_completo }}
                                    </option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="search-empresa">Empresa:</label>
                            <select
                                data-placeholder="Selecione a empresa"
                                class="form-control"
                                id="search-empresa"
                                v-model="form.empresa"
                                required
                            >
                                <template
                                    v-for="(empresa, index) in this.empresas"
                                    :key="index"
                                >
                                    <option
                                        :value="empresa.empresa_id"
                                        :selected="
                                            empresa.empresa_id ===
                                            this.agendamento?.empresa_id
                                        "
                                    >
                                        {{ empresa.nome_fantasia }}
                                    </option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="telefone">Telefone:</label>
                            <input
                                id="telefone"
                                type="text"
                                class="form-control"
                                v-model="form.telefone"
                                required
                            />
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col">
                        <div class="form-group">
                            <label for="search-procedimento"
                                >Procedimento:</label
                            >
                            <select
                                data-placeholder="Selecione um procedimento"
                                class="form-control"
                                id="search-procedimento"
                                v-model="form.procedimento"
                                required
                            >
                                <template
                                    v-for="(procedimento, index) in this
                                        .procedimentos"
                                    :key="index"
                                >
                                    <option
                                        :value="procedimento.procedimento_id"
                                    >
                                        {{ procedimento.nome }}
                                    </option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="tempo">Tempo:</label>
                            <input
                                type="text"
                                id="tempo"
                                class="form-control"
                                v-model="form.tempo"
                                placeholder="Minutos"
                                required
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="valor">Valor:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text"
                                        id="basic-addon1"
                                        >R$</span
                                    >
                                </div>
                                <input
                                    id="valor"
                                    type="text"
                                    v-money="money"
                                    class="form-control"
                                    v-model="form.valor"
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-5 justify-content-center">
                    <button
                        type="submit"
                        @click="submitForm"
                        :class="buttonClass"
                        class="w-50"
                    >
                        {{ buttonText }}
                    </button>
                    <template v-if="isEditing">
                        <button
                            type="submit"
                            @click="removeForm"
                            class="btn btn-danger mt-3 w-50"
                        >
                            Excluir
                        </button>
                    </template>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "../Components/Navbar.vue";
import Swal from "sweetalert2/dist/sweetalert2.js";
import $ from "jquery";
import "select2";
import "jquery-mask-plugin";
import { VMoney } from "v-money";

export default {
    props: {
        info: {
            type: Object,
        },
        agendamento: {
            type: Object,
        },
    },
    components: {
        Navbar,
    },
    data() {
        return {
            form: {
                data: "",
                hora: "",
                status: "",
                colaborador: "",
                empresa: "",
                telefone: "",
                procedimento: "",
                tempo: "",
                valor: "",
            },
            isEditing: false,
            colaboradores: [],
            procedimentos: [],
            empresas: [],
            status: [
                { id: 1, status: "Marcado - não confirmado" },
                { id: 2, status: "Marcado - confirmado" },
                {
                    id: 3,
                    status: "Em atendimento",
                },
                {
                    id: 4,
                    status: "Aguardando | Atendimento",
                },
                {
                    id: 5,
                    status: "Atendido",
                },
            ],
            money: {
                decimal: ",",
                thousands: ".",
                precision: 2,
                masked: false 
            },
        };
    },
    directives: { money: VMoney },
    computed: {
        formattedDate() {
            if (this.info) {
                const date = this.info.dateStr.split("T")[0];
                this.form.data = date;
                return date;
            } else if (this.agendamento) {
                this.form.data = this.agendamento[0].data;
                return this.agendamento[0].data;
            }
        },
        formattedTime() {
            if (this.info) {
                const time = this.info.dateStr.split("T")[1].slice(0, 5);
                this.form.hora = time;
                return time;
            } else if (this.agendamento) {
                this.form.hora = this.agendamento[0].hora;
                return this.agendamento[0].hora;
            }
        },
        buttonClass() {
            return this.isEditing
                ? "btn btn-primary mt-3"
                : "btn btn-success mt-3";
        },
        buttonText() {
            return this.isEditing ? "Salvar" : "Cadastrar";
        },
    },
    methods: {
        submitForm() {
            if (this.isEditing) {
                this.editForm();
            } else {
                this.createForm();
            }
        },
        async removeForm() {
            event.preventDefault();
            await axios
                .post(`/excluir/agendamento/${this.agendamento[0].agendamento_id}`)
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu um erro ao remover o agendamento!"
                    );
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code === 200) {
                        this.exibirModal("success", "Agendamento removido!", 2);
                    } else {
                        this.exibirModal(
                            "error",
                            "Ocorreu um erro ao remover o agendamento!"
                        );
                    }
                });
        },
        async editForm() {
            event.preventDefault();
            await axios
                .put("/atualizar/agendamento", {
                    agendamento_id: this.agendamento[0].agendamento_id,
                    data: this.form.data,
                    hora: this.form.hora,
                    status: this.form.status,
                    colaborador: this.form.colaborador,
                    empresa: this.form.empresa,
                    telefone: this.form.telefone,
                    procedimento: this.form.procedimento,
                    tempo: this.form.tempo,
                    valor: this.form.valor,
                })
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu um erro ao atualizar o agendamento!"
                    );
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code === 200) {
                        this.exibirModal(
                            "success",
                            "Agendamento atualizado!",
                            2
                        );
                    } else {
                        this.exibirModal(
                            "error",
                            "Ocorreu um erro ao atualizar o agendamento!"
                        );
                    }
                });
        },
        async createForm() {
            event.preventDefault();
            await axios
                .post("/adicionar/agendamento", {
                    profissional_id: this.info.profissional_id,
                    data: this.form.data,
                    hora: this.form.hora,
                    status: this.form.status,
                    colaborador: this.form.colaborador,
                    empresa: this.form.empresa,
                    telefone: this.form.telefone,
                    procedimento: this.form.procedimento,
                    tempo: this.form.tempo,
                    valor: this.form.valor,
                })
                .catch((response) => {
                    console.log(response);
                    this.exibirModal(
                        "error",
                        "Ocorreu um erro ao adicionar o agendamento."
                    );
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code === 200) {
                        this.exibirModal("success", "Agendamento concluído", 2);
                    } else {
                        this.exibirModal(
                            "error",
                            "Ocorreu um erro ao adicionar o agendamento."
                        );
                    }
                });
        },
        async fetchColaboradores() {
            await axios.post("/listar/colaboradores").then((response) => {
                this.colaboradores = response.data;
            });
            console.log("colaboradores");
        },
        async fetchEmpresas() {
            await axios.get("/listar/empresas").then((response) => {
                if (response.status === 200) {
                    console.log(response.data);
                    this.empresas = response.data;
                }
            });
            console.log("empresas");
        },
        async fetchProcedimentos() {
            this.modalLoading();
            await axios.get("/listar/procedimentos").then((response) => {
                if (response.status === 200) {
                    this.procedimentos = response.data;
                    $("#search-procedimento")
                        .select2({
                            theme: "bootstrap-5",
                        })
                        .on("change", (e) => {
                            this.form.procedimento = e.target.value;
                            if (!this.isEditing) {
                                for (var procedimento of this.procedimentos) {
                                    if (
                                        procedimento.procedimento_id ==
                                        this.form.procedimento
                                    ) {
                                        this.form.tempo = procedimento.tempo;
                                        this.form.valor = procedimento.valor;
                                    }
                                }
                            }
                        });
                }
            });
            console.log("procedimento");
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
        exibirModal(tipo, mensagem, code) {
            Swal.fire({
                icon: tipo,
                title: mensagem,
                showConfirmButton: false,
                timer: 1500,
                willClose: () => {
                    switch (code) {
                        case 1:
                            this.$inertia.visit("/agenda");
                            break;
                        case 2:
                            window.history.back();
                            break;
                        default:
                            break;
                    }
                },
            });
        },
        completarCampos() {
            $("#search-status").val(this.form.status).trigger("change");
            $("#search-colaborador")
                .val(this.form.colaborador)
                .trigger("change");
            $("#search-procedimento")
                .val(this.form.procedimento)
                .trigger("change");
            $("#search-empresa").val(this.form.empresa).trigger("change");
            Swal.close();
        },
        receberDados() {
            var agendamento = this.agendamento[0];
            this.form.status = agendamento.status_id;
            this.form.colaborador = agendamento.colaborador_id;
            this.form.telefone = agendamento.telefone;
            this.form.procedimento = agendamento.procedimento_id;
            this.form.tempo = agendamento.tempo;
            this.form.valor = agendamento.valor;
            this.form.empresa = agendamento.empresa_id;
            console.log("receberDados");
        },
        iniciarSelect() {
            $("#search-status")
                .select2({
                    theme: "bootstrap-5",
                })
                .on("change", (e) => {
                    this.form.status = e.target.value;
                });

            $("#search-colaborador")
                .select2({
                    theme: "bootstrap-5",
                })
                .on("change", (e) => {
                    this.form.colaborador = e.target.value;
                });

            $("#search-empresa")
                .select2({
                    theme: "bootstrap-5",
                })
                .on("change", (e) => {
                    this.form.empresa = e.target.value;
                });
            console.log("iniciar select");
        },
    },
    mounted() {
        if (this.agendamento) {
            this.isEditing = true;
            this.receberDados();
        }
        $("#telefone").mask("(99) 09999-99999");
        $("#tempo").mask("000");
        this.iniciarSelect();
        Promise.all([
            this.fetchEmpresas(),
            this.fetchColaboradores(),
            this.fetchProcedimentos(),
        ]).then(() => {
            this.completarCampos();
        });
    },
};
</script>
<style>
@import "sweetalert2/dist/sweetalert2.min.css";
@import "bootstrap/dist/css/bootstrap.css";
@import "select2/dist/css/select2.css";
@import "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css";
</style>
