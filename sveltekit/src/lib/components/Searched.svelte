<!--$lib/components/Searched.svelte-->

<script>
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
    <div class="exercise-list">
        <p style="font-size: large;">
            No exercises found for the selected filters
        </p>
    </div>
{/if}

<style lang="scss">
    div {
        h1 {
            font-size: 3rem;
            margin-left: 1rem;
            margin-top: 1rem;
        }
    }
</style>
