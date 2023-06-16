<template>
    <Navbar></Navbar>
    <Transition>
        <div class="container">
            <div class="card shadow-lg p-5 m-5">
                <div class="mb-4">
                    <div class="pb-3">
                        <Link
                            href="/cadastro/colaborador"
                            type="button"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-plus"></i>
                        </Link>
                    </div>
                    <div>
                        <table
                            class="table display table-striped"
                            id="dataTable"
                        >
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Data de nascimento</th>
                                    <th>Celular</th>
                                    <th>Gênero</th>
                                    <th>Criado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template
                                    v-for="(
                                        colaborador, index
                                    ) in colaboradores"
                                    :key="index"
                                >
                                    <tr>
                                        <td>{{ colaborador.nome_completo }}</td>
                                        <td>{{ colaborador.cpf }}</td>
                                        <td>
                                            {{
                                                this.formatarData(
                                                    colaborador.data_nascimento
                                                )
                                            }}
                                        </td>
                                        <td>{{ colaborador.celular }}</td>
                                        <td>{{ colaborador.genero }}</td>
                                        <td>
                                            {{
                                                this.formatarDataHora(
                                                    colaborador.created_at
                                                )
                                            }}
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-around"
                                            >
                                                <Link
                                                    :href="`/colaborador/${colaborador.colaborador_id}`"
                                                    type="button"
                                                    class="btn btn-warning"
                                                >
                                                    <i
                                                        class="bi bi-pencil-square text-white"
                                                    ></i>
                                                </Link>
                                                <button
                                                    type="button"
                                                    class="btn btn-danger"
                                                    @click="
                                                        modalConfirmacao(
                                                            colaborador.colaborador_id,
                                                            index
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="bi bi-trash-fill"
                                                    ></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script>
import Navbar from "../../Components/Navbar.vue";
import DataTable from "datatables.net-dt";
import DataTablesCore from "datatables.net-bs5";
import language from "datatables.net-plugins/i18n/pt-BR.mjs";
import Swal from "sweetalert2/dist/sweetalert2.js";
import moment from "moment";
import $ from "jquery";
import axios from "axios";
import "datatables.net-select";
import "datatables.net-responsive";
import { Link } from "@inertiajs/vue3";
DataTable.use(DataTablesCore);
export default {
    components: {
        Link,
        Navbar,
    },
    data() {
        return {
            opcoes: {
                language: language,
            },
            colaboradores: [],
        };
    },
    methods: {
        async buscarColaboradores() {
            this.modalLoading();
            await axios.post("/listar/colaboradores").then((response) => {
                Swal.close();
                if (response.status === 200) {
                    this.colaboradores = response.data;
                    this.$nextTick(() => {
                        $("#dataTable").DataTable(this.opcoes);
                    });
                }
            });
        },
        async removerColaborador(colaborador_id, array_id) {
            this.modalLoading();
            await axios
                .post("/remover/colaborador", {
                    colaborador_id: colaborador_id,
                })
                .catch((response) => {
                    this.exibirModal(
                        "error",
                        "Ocorreu um erro ao excluir o colaborador."
                    );
                })
                .then((response) => {
                    Swal.close();
                    console.log(response);
                    if (response.data.code == 200) {
                        this.colaboradores.splice(array_id, 1);
                        $("#dataTable").DataTable().destroy();
                        this.$nextTick(() => {
                            $("#dataTable").DataTable(this.opcoes);
                        });
                        this.exibirModal(
                            "success",
                            "Colaborador excluído sucesso!"
                        );
                    } else {
                        this.exibirModal(
                            "error",
                            "Ocorreu um erro ao excluir o colaborador."
                        );
                    }
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
        modalConfirmacao(colaborador_id, array_id) {
            Swal.fire({
                title: "Você realmente deseja remover este colaborador?",
                text: "A exclusão é irreversível!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.removerColaborador(colaborador_id, array_id);
                }
            });
        },
        exibirModal(tipo, mensagem) {
            Swal.fire({
                icon: tipo,
                title: mensagem,
                showConfirmButton: false,
                timer: 1500,
            });
        },
        formatarDataHora(dataHora) {
            return moment(dataHora).format("DD/MM/YYYY HH:mm:ss");
        },
        formatarData(data) {
            return moment(data).format("DD/MM/YYYY");
        },
    },
    mounted() {
        this.buscarColaboradores();
    },
};
</script>

<style>
@import "bootstrap-icons/font/bootstrap-icons.css";
@import "bootstrap/dist/css/bootstrap.css";
@import "datatables.net-bs5";
@import "sweetalert2/dist/sweetalert2.min.css";
@import "mosha-vue-toastify/dist/style.css";
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
</style>
