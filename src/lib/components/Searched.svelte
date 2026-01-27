<!--$lib/components/Searched.svelte-->

<script>
    import { formatOption } from "../utils/format";
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
            <button
                type="button"
                onclick={() => {
                    selectedExercise.set(exercise);
                    searched.set(false);
                }}
                class="exercise-item"
            >
                <h2>{exercise.name}</h2>
                <p>Primary Muscle: {formatOption(exercise.muscle)}</p>
                <p>Equipments: {exercise.equipments.map(e => formatOption(e)).join(', ')}</p>
                <p>Exercise Type: {formatOption(exercise.type)}</p>
                <p>Difficulty: {formatOption(exercise.difficulty)}</p>
            </button>
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
