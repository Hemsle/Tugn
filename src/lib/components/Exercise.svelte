<!--$lib/components/Exercise.svelte-->
<script>
    import { filteredExercises, searched, selectedExercise} from "$lib/stores/exerciseStore";//Man väljer en övning från library eller filteredExercises
    import { formatOption } from "../utils/format.js";
    
    function back() {
        if (filteredExercises === []) {  
            searched.set(false);  
            selectedExercise.set(null);
            filteredExercises === [];   
        } else {    
            selectedExercise.set(null);
            searched.set(true);
        } 
    }
</script>

<div id="chosenExercise">
    {#if $selectedExercise}
        <button onclick={back}>Back</button>
        <h1>{$selectedExercise.name}</h1>
        <h3>Muscle: {formatOption($selectedExercise.muscle)}</h3>
        <h3>Equipment: {formatOption($selectedExercise.equipment)}</h3>
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
    {:else }
        <h1>No exercise selected</h1>
        <img src="icons/tugnIcon.png" alt="Hammare" />
    {/if}
</div>

<style lang="scss">
    #chosenExercise {
        font-family: "DM Sans", sans-serif;
        margin: 2rem;
        height: 94%;
        padding: 4rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        overflow-x: auto;
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
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            h2 {
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

    /* From Uiverse.io by SteveBloX */
    img {
        box-sizing: border-box;
        width: 40rem;
        background: rgba(217, 217, 217, 0.58);
        border: 1px solid white;
        box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
        backdrop-filter: blur(5px);
        border-radius: 17px;
        text-align: center;
        cursor: pointer;
        transition: all 20s;
        user-select: none;
        font-weight: bolder;
        color: black;

        &:hover {
            border: 1px solid black;
            transform: scale(10) rotate(-90deg);
        }

        &:active {
            transform: scale(0.001) rotateZ(90deg);
            border-radius: 20rem;
            box-shadow: 12rem 17rem 51rem rgba(0, 0, 0, 0.22);
        }
    }
</style>
