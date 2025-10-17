<!--$lib/components/Exercise.svelte-->
<script>
    import { selectedExercise } from "$lib/stores/exerciseStore";
    import { formatOption } from "../utils/format.js";
</script>

<div id="chosenExercise">
    {#if $selectedExercise}
        <h1>{$selectedExercise.name}</h1>
        <h3>Muscle: {formatOption($selectedExercise.muscle)}</h3>
        <h3>Equipment: {formatOption($selectedExercise.equipment)}</h3>
        <h3>Type: {formatOption($selectedExercise.type)}</h3>
        <h3>Difficulty: {formatOption($selectedExercise.difficulty)}</h3>
        <div>
            <h2>Instructions:</h2>
            <p>{$selectedExercise.instructions}</p>
        </div>
    {:else}
        <h1>No exercise selected</h1>
    {/if}
</div>

<style lang="scss">
    #chosenExercise {
        margin: 2rem;
        height: 94%;
        padding: 4rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        h1 {
            font-size: 4rem;
            font-weight: large;
        }
        h3 {
            font-size: 1.5rem;
            padding-left: 0.5rem;
        }
        div {
            margin-top: 1rem;
            padding: 1rem;
            overflow-x: auto;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            max-height: 75%;
            h2{ 
                font-size: 2rem;
                position: sticky;
            }
            p {
                font-size: 2rem;
                margin-left: 3rem;
                margin-right: 3rem;
            }
        }
    }
</style>
