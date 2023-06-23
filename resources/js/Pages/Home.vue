<template>
    <Navbar></Navbar>
    <div class="container pt-5">
        <h1>Agenda</h1>
        <div class="form-group my-3">
            <label class="fw-bold">Profissional:</label>
            <select
                data-placeholder="Selecione um profissional"
                class="form-control"
                v-model="profissional_id"
                id="search-profissional"
                required
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
        <Transition>
            <template v-if="profissional_id">
                <div class="pt-5">
                    <FullCalendar :options="calendarOptions" />
                </div>
            </template>
        </Transition>
    </div>
</template>

<script type="module">
import FullCalendar from "@fullcalendar/vue3";
import timeGridPlugin from "@fullcalendar/timegrid";
import ptBrLocale from "@fullcalendar/core/locales/pt-br";
import Navbar from "../Components/Navbar.vue";
import interactionPlugin from "@fullcalendar/interaction";
import axios from "axios";
import "select2/dist/css/select2.css";
import "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css";
import "select2";
import $ from "jquery";
import Swal from "sweetalert2/dist/sweetalert2";
import { createToast } from "mosha-vue-toastify";
export default {
    components: {
        FullCalendar,
        Navbar,
    },
    mounted() {
        this.buscarProfissionais();
        this.iniciarSelect();
    },
    data() {
        return {
            calendarOptions: {
                aspectRatio: 0.1,
                expandRows: true,
                allDaySlot: false,
                slotMinTime: "08:00:00",
                slotEventOverlap: false,
                plugins: [timeGridPlugin, interactionPlugin],
                locale: ptBrLocale,
                editable: false,
                selectable: true,
                eventClick: this.verAgendamento,
                dateClick: this.captureData,
                headerToolbar: {
                    left: "prev,next",
                    center: "title",
                    right: "timeGridWeek,timeGridDay",
                },
                slotLabelFormat: {
                    hour: "numeric",
                    minute: "2-digit",
                    omitZeroMinute: false,
                },
                events: [],
            },
            profissional_id: "",
            profissionais: [],
        };
    },
    methods: {
        verAgendamento(agendamento) {
            console.log(agendamento);
            this.$inertia.get(`/agendamento/${agendamento.event.id}`);
        },
        captureData(info) {
            info.profissional_id = this.profissional_id;
            this.$inertia.post("/agendamento", { info: info });
        },
        buscarAgendamentos() {
            this.modalLoading();
            axios
                .get(`/agendamentos/${this.profissional_id}`)
                .then(async (response) => {
                    this.calendarOptions.events = await Promise.all(
                        response.data.map(async (agendamento) => {
                            const collaboratorResponse = await axios.post(
                                `/buscar/colaborador/${agendamento.colaborador_id}`
                            );
                            const nomeColaborador =
                                collaboratorResponse.data.nome_completo;
                            const dataInicio = `${agendamento.data} ${agendamento.hora}`;
                            const tempoMinutos = agendamento.tempo;
                            const dataFim = this.adicionarMinutos(
                                dataInicio,
                                tempoMinutos
                            );

                            return {
                                id: agendamento.agendamento_id,
                                title: nomeColaborador,
                                start: dataInicio,
                                end: dataFim,
                            };
                        })
                    );
                    this.$nextTick(() => Swal.close());
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
        buscarProfissionais() {
            axios.get("/listar/profissionais").then((response) => {
                if (response.data) {
                    this.profissionais = response.data;
                    console.log("Buscou");
                }
            });
        },
        adicionarMinutos(dataHora, minutos) {
            const data = new Date(dataHora);
            data.setMinutes(data.getMinutes() + minutos);
            return data.toISOString();
        },
        iniciarSelect() {
            $("#search-profissional")
                .select2({
                    theme: "bootstrap-5",
                })
                .on("change", (e) => {
                    this.profissional_id = e.target.value;
                    this.buscarAgendamentos();
                });
        },
    },
};
</script>
<style>
@import "bootstrap/dist/css/bootstrap.css";
@import "sweetalert2/dist/sweetalert2.min.css";
@import "mosha-vue-toastify/dist/style.css";
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
