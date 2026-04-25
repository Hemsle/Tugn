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
        // testa implentera fuzzy search!!!
        //detta funkar inte än och funderar på att detta eventuellt blir lättre med databaser
        const query = searchTerms.toLowerCase().replace(/-/g, " ").trim();

        const results = exercises.filter((exercise) => {
            //går igenom att övningar och jämför vad som är i selection
            const muscleMatch =
                selectedMuscle === "all_muscles" ||
                exercise.muscle === selectedMuscle;

            //övningars equipment kan bestå av tom array eller en array med flera equipments
            const equipmentMatch =
                selectedEquipment === "all_equipments" ||
                (exercise.equipments &&
                    exercise.equipments.includes(selectedEquipment));

            const typeMatch =
                selectedType === "all_types" || exercise.type === selectedType;

            const difficultyMatch =
                selectedDifficulty === "all_difficulties" ||
                exercise.difficulty === selectedDifficulty;

            const termsMatch =
                query === "" ||
                exercise.name
                    .toLowerCase()
                    .replace(/-/g, " ")
                    .includes(query) ||
                exercise.muscle.toLowerCase().includes(query) ||
                exercise.type.toLowerCase().includes(query) ||
                (exercise.equipments &&
                    exercise.equipments.some((eq) =>
                        eq.toLowerCase().replace(/-/g, " ").includes(query),
                    ));

            return (
                //returnerar värden i results
                muscleMatch &&
                equipmentMatch &&
                typeMatch &&
                difficultyMatch &&
                termsMatch
            );
        });

        const isFilter =
            query !== "" ||
            selectedMuscle !== "all_muscles" ||
            selectedEquipment !== "all_equipments" ||
            selectedType !== "all_types" ||
            selectedDifficulty !== "all_difficulties";

        //om ändringar sker
        if (isFilter) {
            //om selection inte är helt tom så filtreras sökningen efter results
            filteredExercises.set(results);
            searched.set(true); //ser till att visa sökresultatet
        } else {
            filteredExercises.set([]);
            searched.set(false);
        }
    });

    function resetFilters() {
        //försklarar sig själv, resetar allt, filter, sökning osv...
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

<div class="search-container">
    <img src="/icons/searchglass.png" alt="search icon" class="search-icon" />
    <input
        type="text"
        bind:value={searchTerms}
        placeholder="Search for exercises..."
    />
</div>

<button onclick={resetFilters}> Reset </button>

<style lang="scss">
    select {
        border-radius: 1rem;
        width: 12rem;
        margin-bottom: 0.5rem;
    }

    .search-container {
        display: flex;
        align-items: center;
        background-color: #efefef;
        padding: 0.6rem 1.2rem;
        border-radius: 2rem;
        width: 100%;
        border: 1px solid transparent;
        margin-bottom: 0.5rem;

        &:focus-within {
            background-color: white;
            border-color: var(--third);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .search-icon {
            width: 2rem;
            opacity: 0.5;
            margin-right: 0.8rem;
        }

        input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-family: inherit;
            font-size: 1.3rem;
            color: #333;

            &::placeholder {
                color: #aaa;
            }
        }
    }
</style>
