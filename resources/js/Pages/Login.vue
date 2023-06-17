<template>
    <section class="vh-100 d-flex">
        <div class="container-fluid">
            <div
                class="row d-flex justify-content-center align-items-center h-100"
            >
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img
                        src="../../assets/5207289.jpg"
                        class="img-fluid"
                        alt="Sample image"
                    />
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form>
                        <!-- <div
                            class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start pb-5"
                        >
                            <p class="lead fw-normal mb-0 me-3">Entrar como:</p>
                            <button
                                type="button"
                                class="btn btn-primary btn-floating mx-1"
                            >
                                <i class="bi bi-heart-pulse"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary btn-floating mx-1"
                            >
                                <i class="bi bi-person-gear"></i>
                            </button>
                        </div> -->

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3"
                                >Email:</label
                            >
                            <input
                                type="email"
                                id="form3Example3"
                                class="form-control form-control-lg"
                                v-model="form.email"
                                required
                            />
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="form3Example4"
                                >Senha:</label
                            >
                            <input
                                type="password"
                                v-model="form.senha"
                                id="form3Example4"
                                class="form-control form-control-lg"
                                required
                            />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button
                                @click="fazerLogin()"
                                type="submit"
                                class="btn btn-primary btn-lg"
                                style="
                                    padding-left: 2.5rem;
                                    padding-right: 2.5rem;
                                "
                            >
                                Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import axios from "axios";
import { createToast } from "mosha-vue-toastify";
export default {
    data() {
        return {
            form: {
                email: "",
                senha: "",
            },
        };
    },
    methods: {
        fazerLogin() {
            event.preventDefault();
            axios
                .post("/verificarlogin", {
                    email: this.form.email,
                    senha: this.form.senha,
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.code == 200) {
                        const dadosJSON = JSON.stringify(
                            response.data.profissional
                        );
                        localStorage.setItem("profissional", dadosJSON);
                        this.$inertia.get(`/agenda`);
                    } else {
                        createToast(response.data.message, {
                            type: "danger",
                            showIcon: true,
                            timeout: 2500,
                        });
                    }
                });
        },
    },
};
</script>
<style>
@import "bootstrap-icons/font/bootstrap-icons.css";
@import "mosha-vue-toastify/dist/style.css";
</style>
