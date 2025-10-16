<!--$lib/components/Searched.svelte-->

<script>
    import { formatOption } from "../utils/format";
    import { filteredExercises } from "../stores/exerciseStore.js";
</script>

<div>
    <h1>Filtered Exercises</h1>
</div>
{#if $filteredExercises.length > 0}
    <div class="exercise-list">
        {#each $filteredExercises as exercise}
            <h2>
                {exercise.name}
                <p>Primary Muscle: {formatOption(exercise.muscle)}</p>
                <p>Equipment: {formatOption(exercise.equipment)}</p>
                <p>Exercise Type:{formatOption(exercise.type)}</p>
                <p>Difficulty: {formatOption(exercise.difficulty)}</p>
            </h2>
        {/each}
    </div>
{:else}
<p style="font-size: large; margin-left: 2rem;">No exercises found for the selected filters</p>
{/if}

<style lang="scss">
    div {
        margin: 2rem;
    }
    .exercise-list {
        margin-top: -1.2rem;
        height: 89%;
        overflow-x: auto;
        padding: 1rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        h2 {
            font-size: 2rem;
            padding: 2rem;
            margin: 2rem;
            p {
                font-size: small;
                font-weight: 100s;
            }
            &:hover {
                background-color: rgb(231, 231, 231);
                border: 0.1 rem solid rgb(231, 231, 231);
                border-radius: 1rem;
            }
        }
    }
</style>
