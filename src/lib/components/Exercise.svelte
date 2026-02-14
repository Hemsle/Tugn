<!--$lib/components/Exercise.svelte-->
<script>
    import {
        exerciseArray,
        filteredExercises,
        searched,
        selectedExercise,
    } from "$lib/stores/exerciseStore"; //Man väljer en övning från library eller filteredExercises
    import { formatOption } from "../utils/format.js";

    function back() {
        if ($filteredExercises.length > 0) {
            searched.set(true);
        } else {
            searched.set(false);
            filteredExercises.set([]);
        }
        selectedExercise.set(null);
    }
</script>

<div id="chosenExercise">
    {#if $selectedExercise}
        <button onclick={back}>Back</button>
        <h1>{$selectedExercise.name}</h1>
        <h3>Muscle: {formatOption($selectedExercise.muscle)}</h3>
        <h3>
            Equipments: {$selectedExercise.equipments
                .map((e) => formatOption(e))
                .join(", ")}
        </h3>
        <h3>Type: {formatOption($selectedExercise.type)}</h3>
        <h3>Difficulty: {formatOption($selectedExercise.difficulty)}</h3>
        <div>
            <h2>Instructions:</h2>
            <p>{$selectedExercise.instructions}</p>
        </div>
        <div>
            <h2>Safety Information</h2>
            <p>{$selectedExercise.safety_info}</p>
        </div>
    {:else}
        <h1>No exercise selected</h1>

    {/if}
</div>

<style lang="scss">
    
</style>
