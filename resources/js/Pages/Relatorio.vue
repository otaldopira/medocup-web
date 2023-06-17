<template>
    <Navbar></Navbar>
    <div class="container">
        <div class="card shadow-lg p-5 m-5">
            <h2>Relatórios</h2>
            <div class="row my-2">
                <div class="col">
                    <div class="form-group">
                        <label for="data"><i class="text-danger">* </i>Data início:</label>
                        <input
                            type="date"
                            id="data"
                            class="form-control"
                            v-model="form.data_inicio"
                            required
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="data"><i class="text-danger">* </i>Data fim:</label>
                        <input
                            type="date"
                            id="data"
                            class="form-control"
                            v-model="form.data_fim"
                            required
                        />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="search-empresa">Empresa:</label>
                        <select
                            data-placeholder="Selecione a empresa"
                            class="form-control"
                            id="search-empresa"
                            v-model="form.empresa"
                        >
                            <template
                                v-for="(empresa, index) in this.empresas"
                                :key="index"
                            >
                                <option :value="empresa.empresa_id">
                                    {{ empresa.nome_fantasia }}
                                </option>
                            </template>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label class="font-weight-bold">Profissional:</label>
                        <select
                            data-placeholder="Selecione um profissional"
                            class="form-control"
                            v-model="form.profissional"
                            id="search-profissional"
                        >
                            <template
                                v-for="(profissional, index) in profissionais"
                                :key="index"
                            >
                                <option :value="profissional.profissional_id">
                                    {{ profissional.nome }}
                                </option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>
            <div
                class="btn btn-primary mt-5 w-50 mx-auto"
                @click="verificarDados()"
            >
                Gerar
            </div>
        </div>
    </div>
</template>
<script>
import pdfMake, { log } from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import { createToast } from "mosha-vue-toastify";
import Navbar from "../Components/Navbar.vue";
import $ from "jquery";
import axios from "axios";
import "select2";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
export default {
    data() {
        return {
            form: {
                empresa: "",
                profissional: "",
                data_inicio: "",
                data_fim: "",
            },
            agendamentos: [],
            empresas: [],
            profissionais: [],
        };
    },
    components:{
        Navbar
    },  
    methods: {
        gerarRelatorio(titulo) {
            this.resetarValores()
            let total = 0;
            const conteudoRelatorio = [
                {
                    text: titulo,
                    style: "titulo",
                },
                {
                    style: "tabela",
                    table: {
                        headerRows: 1,
                        body: [
                            [
                                {
                                    text: "Colaborador",
                                    style: "tableHeader",
                                },
                                {
                                    text: "Empresa",
                                    style: "tableHeader",
                                },
                                {
                                    text: "Profissional",
                                    style: "tableHeader",
                                },
                                {
                                    text: "Procedimento",
                                    style: "tableHeader",
                                },
                                {
                                    text: "Data",
                                    style: "tableHeader",
                                },
                                {
                                    text: "Hora",
                                    style: "tableHeader",
                                },
                                {
                                    text: "Valor",
                                    style: "tableHeader",
                                },
                            ],
                        ],
                    },
                    layout: {
                        fillColor: function (rowIndex, node, columnIndex) {
                            return rowIndex % 2 === 0 ? "#CCCCCC" : null;
                        },
                    },
                },
            ];

            for (const agendamento of this.agendamentos) {
                total += parseFloat(agendamento.valor);
                conteudoRelatorio[1].table.body.push([
                    agendamento.nome_colaborador,
                    agendamento.nome_empresa,
                    agendamento.nome_profissional,
                    agendamento.nome_procedimento,
                    agendamento.data.split("-").reverse().join("/"),
                    agendamento.hora.slice(0, -3),
                    `R$ ${agendamento.valor
                        .replace(".", ",")
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")}`,
                ]);
            }

            conteudoRelatorio[1].table.body.push([
                {
                    style: "tableHeader",
                    alignment: "right",
                    colSpan: 7,
                    text: `Total: R$ ${total
                        .toFixed(2)
                        .replace(".", ",")
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")}`,
                },
            ]);

            const estilosRelatorio = {
                tableHeader: {
                    bold: true,
                    fontSize: 13,
                    color: "black",
                },
                titulo: { fontSize: 18, bold: true, margin: [0, 0, 0, 10] },
                paragrafo: { fontSize: 12 },
                tabela: { fontSize: 12 },
            };

            const opcoesDocumento = {
                content: conteudoRelatorio,
                styles: estilosRelatorio,
            };

            this.relatorio = pdfMake.createPdf(opcoesDocumento);
            this.relatorio.open();
        },
        verificarDados() {
            if (
                this.form.empresa &&
                this.form.profissional &&
                this.form.data_inicio &&
                this.form.data_fim
            ) {
                this.retalorioGeral();
            } else if (
                this.form.empresa &&
                this.form.data_inicio &&
                this.form.data_fim
            ) {
                this.retalorioByEmpresa();
            } else if (
                this.form.profissional &&
                this.form.data_inicio &&
                this.form.data_fim
            ) {
                this.retalorioByProfissional();
            } else {
                createToast("Campos estão incompletos", {
                    type: "danger",
                    showIcon: true,
                    timeout: 2500,
                });
            }
        },
        async fetchEmpresas() {
            await axios.get("/listar/empresas").then((response) => {
                if (response.status === 200) {
                    console.log(response.data);
                    this.empresas = response.data;
                }
            });
        },
        async fetchProfissionais() {
            await axios.get("/listar/profissionais").then((response) => {
                if (response.data) {
                    this.profissionais = response.data;
                }
            });
        },
        async retalorioByProfissional() {
            await axios
                .post("/relatorio/buscar/profissional", {
                    profissional_id: this.form.profissional,
                    data_inicio: this.form.data_inicio,
                    data_fim: this.form.data_fim,
                })
                .then((response) => {
                    this.agendamentos = response.data.agendamentos;
                    if (this.agendamentos.length === 0) {
                        createToast(
                            "Não contém dados para realizar o relatório",
                            {
                                type: "danger",
                                showIcon: true,
                                timeout: 2500,
                            }
                        );
                    } else {
                        this.gerarRelatorio(
                            "Relatórios de atendimentos por profissional"
                        );
                    }
                });
        },
        async retalorioByEmpresa() {
            await axios
                .post("/relatorio/buscar/empresa", {
                    empresa_id: this.form.empresa,
                    data_inicio: this.form.data_inicio,
                    data_fim: this.form.data_fim,
                })
                .then((response) => {
                    console.log(response);
                    if (response.status === 200) {
                        this.agendamentos = response.data.agendamentos;
                        if (this.agendamentos.length === 0) {
                            createToast(
                                "Não contém dados para realizar o relatório",
                                {
                                    type: "danger",
                                    showIcon: true,
                                    timeout: 2500,
                                }
                            );
                        } else {
                            this.gerarRelatorio(
                                "Relatórios de atendimentos por empresa"
                            );
                        }
                    }
                });
        },
        async retalorioGeral() {
            await axios
                .post("/relatorio/buscar/geral", {
                    profissional_id: this.form.profissional,
                    empresa_id: this.form.empresa,
                    data_inicio: this.form.data_inicio,
                    data_fim: this.form.data_fim,
                })
                .then((response) => {
                    console.log(response);
                    if (response.status === 200) {
                        this.agendamentos = response.data.agendamentos;
                        if (this.agendamentos.length === 0) {
                            createToast(
                                "Não contém dados para realizar o relatório",
                                {
                                    type: "danger",
                                    showIcon: true,
                                    timeout: 2500,
                                }
                            );
                        } else {
                            this.gerarRelatorio(
                                "Relatórios de atendimentos por empresa e profissional"
                            );
                        }
                    }
                });
        },
        iniciarSelect() {
            $("#search-profissional")
                .select2({
                    theme: "bootstrap-5",
                })
                .on("change", (e) => {
                    this.form.profissional = e.target.value;
                });

            $("#search-empresa")
                .select2({
                    theme: "bootstrap-5",
                })
                .on("change", (e) => {
                    this.form.empresa = e.target.value;
                });
        },
        resetarValores() {
            this.form.empresa = "";
            this.form.profissional = "";
            $("#search-profissional").val(this.form.profissional).trigger("change");
            $("#search-empresa").val(this.form.empresa).trigger("change");
        },
    },
    mounted() {
        this.fetchEmpresas();
        this.fetchProfissionais();
        this.iniciarSelect();
    },
};
</script>
<style>
@import "sweetalert2/dist/sweetalert2.min.css";
@import "bootstrap/dist/css/bootstrap.css";
@import "select2/dist/css/select2.css";
@import "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css";
@import "mosha-vue-toastify/dist/style.css";
</style>
