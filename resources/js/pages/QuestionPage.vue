<template>
    <div class="container">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
import Answers from "../components/Answers.vue";
import Question from "../components/Question.vue";

export default {
    components: { Question, Answers },

    props: ['question'],
}
</script>
