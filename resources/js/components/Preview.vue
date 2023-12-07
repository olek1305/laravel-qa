<template>
    <div class="row">
        <div class="col-4">
            <div class="ml-auto">
                <button class="btn btn-sm btn-primary" @click="togglePreview">Preview</button>
            </div>
        </div>
        <div class="col-4"></div>
        <div class="col-4"></div>
        <div v-if="showPreview" class="col-md-12 bg-secondary text-white">
            <div>
                <div>
                    <div v-html="preview" class="mt-3"></div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</template>
<script>
import MarkdownIt from 'markdown-it';
import prism from 'markdown-it-prism';

const md = new MarkdownIt();
md.use(prism);
export default {
    props: ['body'],

    data() {
        return {
            showPreview: false
        };
    },

    computed: {
        preview() {
            return md.render(this.body);
        }
    },

    methods: {
        togglePreview() {
            this.showPreview = !this.showPreview;
        }
    }
}
</script>
