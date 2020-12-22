<template>
    <main-section>
        <section-header>
            <slot name="header"></slot>
        </section-header>

        <section-title>
            <slot name="title"></slot>
        </section-title>

        <section-content>
            <slot name="content"></slot>
        </section-content>

        <section-footer>
            <slot name="footer"></slot>
        </section-footer>
    </main-section>
</template>

<script>
import LogoLight from "@/Components/Logos/LogoLight";
import Navbar from "@/Components/Navbars/Navbar";
import NavbarLink from "@/Components/Navbars/NavbarLink";
import Dropdown from "@/Components/Dropdowns/Dropdown";
import DropdownLink from "@/Components/Dropdowns/DropdownLink";
import MainSection from "@/Components/Sections/MainSection";
import SectionTitle from "@/Components/Sections/SectionTitle";
import SectionContent from "@/Components/Sections/SectionContent";
import SectionHeader from "@/Components/Sections/SectionHeader";
import SectionFooter from "@/Components/Sections/SectionFooter";

export default {
    components: {
        LogoLight,
        Navbar,
        NavbarLink,
        Dropdown,
        DropdownLink,
        MainSection,
        SectionTitle,
        SectionContent,
        SectionHeader,
        SectionFooter
    }
};
</script>
