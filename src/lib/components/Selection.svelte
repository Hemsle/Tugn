<!--$lib/componentes/Selection.svelte-->

<script>
    import { formatOption } from "../utils/format.js";
    import { filteredExercises, searched } from "../stores/exerciseStore";

    export let data;

    const exercises = data.exercises || [];
    const muscles = data.muscles || [];
    const equipments = data.equipments || [];
    const types = data.types || [];
    const difficulties = data.difficulties || [];

    console.log("Muscles:", muscles);
    console.log("Equipment:", equipments);
    console.log("Type:", types);
    console.log("Difficulty:", difficulties);

    let selectedMuscle = "all_muscles";
    let selectedEquipment = "all_equipments";
    let selectedType = "all_types";
    let selectedDifficulty = "all_difficulties";

    function search() {
        if(selectedMuscle === "all_muscles" && 
            selectedEquipment === "all_equipments" && 
            selectedType === "all_types" && 
            selectedDifficulty === "all_difficulties"
        ) {
            alert("Please select at least one filter before searching.");
            return; 
        }

        const results = exercises.filter(exercise => {
            const muscleMatch = selectedMuscle === "all_muscles" || exercise.muscle === selectedMuscle;
            const equipmentMatch = selectedEquipment === "all_equipments" || exercise.equipment === selectedEquipment;
            const typeMatch = selectedType === "all_types" || exercise.type === selectedType;
            const difficultyMatch = selectedDifficulty === "all_difficulties" || exercise.difficulty === selectedDifficulty;

            return muscleMatch && equipmentMatch && typeMatch && difficultyMatch;
        });
    
        searched.set(true);
        filteredExercises.set(results); // Uppdaterar store
        console.log("Filtered Exercises:", results);
    }   
    
</script>

<select bind:value={selectedMuscle} id="muscle-select">
    <option value="all_muscles">All Muscles</option>
    {#each muscles as muscle}
        <option value={muscle}>{formatOption(muscle)}</option>
    {/each}
</select>
<select bind:value={selectedEquipment} id="equipment-select">
    <option value="all_equipments">All Equipments</option>
    {#each equipments as equipment}
        <option value={equipment}>{formatOption(equipment)}</option>
    {/each}
</select>
<select bind:value={selectedType} id="type-select">
    <option value="all_types">All Types</option>
    {#each types as type}
        <option value={type}>{formatOption(type)}</option>
    {/each}
</select>
<select bind:value={selectedDifficulty} id="difficulty-select">
    <option value="all_difficulties">All Difficulties</option>
    {#each difficulties as difficulty}
        <option value={difficulty}>{formatOption(difficulty)}</option>
    {/each}
</select>
<button on:click={search}>Search Exercises</button>

<button on:click={() => {
    selectedMuscle = "all_muscles";
    selectedEquipment = "all_equipments";
    selectedType = "all_types";
    selectedDifficulty = "all_difficulties";
    searched.set(false);
    filteredExercises.set([]);
}}>
    Reset
</button>

<style lang="scss">
    select {
        width: 12rem;
    }
</style>
