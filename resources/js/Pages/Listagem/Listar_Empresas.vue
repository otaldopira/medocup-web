<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <div class="py-2">
                <div class="mb-4">
                    <Link
                        href="/cadastro/empresa"
                        type="button"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-plus"></i>
                    </Link>
                </div>
            </div>
            <div>
                <table class="table display table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nome Fantasia</th>
                            <th>CNPJ</th>
                            <th>Criado</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template
                            v-for="(empresa, index) in empresas"
                            :key="index"
                        >
                            <tr>
                                <td>{{ empresa.nome_fantasia }}</td>
                                <td>{{ empresa.cnpj }}</td>
                                <td>
                                    {{
                                        this.formatarDataHora(
                                            empresa.created_at
                                        )
                                    }}
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <Link
                                            :href="`/empresa/${empresa.empresa_id}`"
                                            type="button"
                                            class="btn btn-warning"
                                        >
                                            <i
                                                class="bi bi-pencil-square text-white"
                                            ></i>
                                        </Link>
                                        <div class="mx-1"></div>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            @click="
                                                modalConfirmacao(
                                                    empresa.empresa_id,
                                                    index
                                                )
                                            "
                                        >
                                            <i class="bi bi-trash-fill"></i>
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
import { createToast } from "mosha-vue-toastify";
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
            empresas: [],
        };
    },
    methods: {
        async buscarEmpresas() {
            this.modalLoading();
            await axios.get("/listar/empresas").then((response) => {
                Swal.close();
                if (response.status === 200) {
                    this.empresas = response.data;
                    this.$nextTick(() => {
                        $("#dataTable").DataTable(this.opcoes);
                    });
                }
            });
        },
        async removerEmpresa(empresa_id, array_id) {
            this.modalLoading();
            await axios
                .post(`/remover/empresa/${empresa_id}`)
                .catch((_) => {
                    createToast("Erro ao remover a empresa!", {
                        type: "danger",
                        showIcon: "true",
                        timeout: 2500,
                    });
                })
                .then((response) => {
                    Swal.close();
                    console.log(response);
                    if (response.data.code == 200) {
                        this.empresas.splice(array_id, 1);
                        $("#dataTable").DataTable().destroy();
                        this.$nextTick(() => {
                            $("#dataTable").DataTable(this.opcoes);
                        });
                        createToast("Empresa removida", {
                            type: "success",
                            showIcon: "true",
                            timeout: 2500,
                        });
                    } else {
                        createToast("Empresa contém colaboradores vinculados!", {
                            type: "danger",
                            showIcon: "true",
                            timeout: 2500,
                        });
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
        modalConfirmacao(empresa_id, array_id) {
            Swal.fire({
                title: "Você realmente deseja remover está empresa?",
                text: "A exclusão é irreversível!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.removerEmpresa(empresa_id, array_id);
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
        this.buscarEmpresas();
    },
};
</script>

<style>
@import "bootstrap-icons/font/bootstrap-icons.css";
@import "bootstrap/dist/css/bootstrap.css";
@import "datatables.net-bs5";
@import "sweetalert2/dist/sweetalert2.min.css";
@import "mosha-vue-toastify/dist/style.css";
</style>
