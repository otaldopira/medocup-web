<template>
    <nav class="navbar navbar-expand-lg bg-ligth rounded shadow-lg">
        <div class="container-fluid">
            <img
                class="navbar-brand"
                src="../../assets/medocup.logo.png"
                alt="Logo da Navegação"
                width="40"
                height="50"
            />
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <Link
                            class="nav-link font-weight-bold"
                            aria-current="page"
                            href="/agenda"
                            >Agenda</Link
                        >
                    </li>
                    <li class="nav-item">
                        <Link
                            class="nav-link font-weight-bold"
                            aria-current="page"
                            href="/relatorio"
                            >Relatórios</Link
                        >
                    </li>
                    <li class="nav-item dropdown">
                        <Link
                            class="nav-link"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <i class="bi bi-database-fill"></i>
                        </Link>
                        <ul class="dropdown-menu">
                            <li>
                                <Link
                                    class="dropdown-item"
                                    href="/colaboradores"
                                    >Colaboradores</Link
                                >
                            </li>
                            <li>
                                <Link class="dropdown-item" href="/empresas"
                                    >Empresas</Link
                                >
                            </li>
                            <li>
                                <Link
                                    class="dropdown-item"
                                    href="/procedimentos"
                                    >Procedimentos</Link
                                >
                            </li>
                            <li>
                                <Link
                                    class="dropdown-item"
                                    href="/profissionais"
                                    >Profissionais</Link
                                >
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="nav-item d-flex">
                <Link aria-current="page" href="/login">
                    <i class="bi bi-box-arrow-in-right text-danger" style="font-size: 25px;"></i
                ></Link>
            </div>
        </div>
    </nav>
</template>
<script>
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        Link,
    },
    data() {
        return {};
    },
    mounted() {},
};
</script>
<style>
@import "bootstrap-icons/font/bootstrap-icons.css";
</style>
