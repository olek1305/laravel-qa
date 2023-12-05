import 'prismjs/themes/prism.css';

export default {
    methods: {
        highlight () {
            const el = this.$refs.bodyHtml;
            console.log('el', el);
            if (el) Prism.highlightAllUnder(el);
        }
    }
}
