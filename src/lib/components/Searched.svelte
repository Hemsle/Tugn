<!--$lib/components/Searched.svelte-->

<script>
    import { formatOption } from "../utils/format";
    import ExerciseItem from "./ExerciseItem.svelte";
    import {
        filteredExercises,
        selectedExercise,
        searched,
    } from "../stores/exerciseStore.js";
</script>

<div>
    <h1>Filtered Exercises</h1>
</div>
{#if $filteredExercises.length > 0}
    <div class="exercise-list">
        {#each $filteredExercises as exercise}
            <ExerciseItem {exercise} view="searched" />
        {/each}
    </div>
{:else}
    <p style="font-size: large; margin-left: 2rem;">
        No exercises found for the selected filters
    </p>
{/if}

<style lang="scss">
    div {
        margin: 2rem;
    }
</style>
