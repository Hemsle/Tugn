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

{#if $filteredExercises.length > 0}
    <div class="exercise-list">
        <h1>Filtered exercises</h1>
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
        margin: 1rem;
        h1 {
            margin-left: 1rem;
        }
    }
</style>
