<!--$lib/componentes/Selection.svelte-->

<script>
    import { formatOption } from "../utils/format.js";
    import {
        filteredExercises,
        searched,
        selectedExercise,
    } from "../stores/exerciseStore";

    let { data } = $props();
    
    const exercises = data.exercises || [];
    const muscles = data.muscles || [];
    const equipments = data.equipments || [];
    const types = data.types || [];
    const difficulties = data.difficulties || [];

    let selectedMuscle = $state("all_muscles");
    let selectedEquipment = $state("all_equipments");
    let selectedType = $state("all_types");
    let selectedDifficulty = $state("all_difficulties");
    let searchTerms = $state("");

    //tanken är att denna ska ändras varje gång en variable ändras...
    $effect(() => {
        const query = searchTerms.toLowerCase().trim();

        const results = exercises.filter((exercise) => {
            const muscleMatch = selectedMuscle === "all_muscles" || exercise.muscle === selectedMuscle;
            const equipmentMatch = selectedEquipment === "all_equipments" || (exercise.equipments && exercise.equipments.includes(selectedEquipment));


            const typeMatch = selectedType === "all_types" || exercise.type === selectedType;
            const difficultyMatch = selectedDifficulty === "all_difficulties" || exercise.difficulty === selectedDifficulty;

            const termsSearch = query === "" ||
                exercise.name.toLowerCase().includes(query) ||
                exercise.muscle.toLowerCase().includes(query) ||
                exercise.equipment.toLowerCase().includes(query);

            return muscleMatch && equipmentMatch && typeMatch && difficultyMatch && termsSearch;
        });
        //om ändringar sker
        if(query !== "" || selectedMuscle !== "all_muscles" || selectedEquipment !== "all_equipments" 
        || selectedType !== "all_types" || selectedDifficulty !== "all_difficulties") {
            filteredExercises.set(results);
            searched.set(true); 
        }
    })


    function resetFilters() {
        selectedMuscle = "all_muscles";
        selectedEquipment = "all_equipments";
        selectedType = "all_types";
        selectedDifficulty = "all_difficulties";
        searched.set(false);
        selectedExercise.set(null);
        filteredExercises.set([]);
        searchTerms = "";
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

<input
    id="searchfield"
    type="text"
    bind:value={searchTerms}
    placeholder="Search for exercises..."
/>
<button onclick={resetFilters}> Reset </button>

<style lang="scss">
    select {
        border-radius: 1rem;
        width: 12rem;
        margin-bottom: 0.5rem;
    }

    input {
        border-radius: 1.5rem;
        padding: 0.3rem;
    }
</style>
