import 'prismjs/themes/prism.css';

export default {
    methods: {
        highlight () {
            const el = this.$refs.bodyHtml;
            if (el) Prism.highlightAllUnder(el);
        }
    }
}
