<!--routes/emptyWorkout/+page.svelte-->
<script>
    import { goto } from "$app/navigation";

    import Library from "$lib/components/Library.svelte";
    import Searched from "$lib/components/Searched.svelte";
    import { formatOption } from "$lib/utils/format.js";
    import {
        addExercises,
        searched,
        selectedExercise,
        filteredExercises,
    } from "$lib/stores/exerciseStore.js"; //addExercises true menar att man väljer övningar från library

    let { data } = $props();

    let showLibrary = $state(false);

    function close() {
        goto("/routines");
    }

    function toggleLibrary() {
        showLibrary = !showLibrary;
        selectedExercise.set(null);
        filteredExercises.set([]);
        searched.set(false);
    }

    function back() {
        if($filteredExercises.length > 0) {
        searched.set(true);
        }
        
        selectedExercise.set(null);
    }
</script>

<section id="workout">
    <section id="top">
        <button onclick={close}>Close</button>
        <h1>Log Workout</h1>
        <button onclick={close}>Finish</button>
    </section>
    <div>
        <p>Här kommer jag lägga duration, volume och sets</p>
    </div>

    <section id="workoutInfo">
        <h2>Här lägger man övningar sedan från API</h2>

        <div class="exercise">
            <p>För varje övning har en egen liten div</p>
        </div>

        <section id="findExercises">
            {#if $searched && showLibrary}
                <Searched />
            {:else if $selectedExercise}
                <div id="chosenExercise">
                    <button onclick={back}>Back</button>
                    <h1>{$selectedExercise.name}</h1>
                    <h3>Muscle: {formatOption($selectedExercise.muscle)}</h3>
                    <h3>
                        Equipments: {$selectedExercise.equipments
                            .map((e) => formatOption(e))
                            .join(", ")}
                    </h3>
                    <h3>Type: {formatOption($selectedExercise.type)}</h3>
                    <h3>
                        Difficulty: {formatOption($selectedExercise.difficulty)}
                    </h3>
                    <div>
                        <h2>Instructions:</h2>
                        <p>{$selectedExercise.instructions}</p>
                    </div>
                    <div>
                        <h2>Safety Information</h2>
                        <p>{$selectedExercise.safety_info}</p>
                    </div>
                </div>
            {/if}
        </section>

        <button
            onclick={() => {
                addExercises.set(true);
                showLibrary = true;
            }}
            id="addExercise"
        >
            <img src="/icons/plus.png" alt="plus" />
            <p>Add Exercise</p>
        </button>
    </section>
</section>

{#if showLibrary === true}
    <section id="search">
        <button id="closeLibrary" onclick={toggleLibrary}>close</button>
        <Library {data} />
    </section>
{/if}

<style lang="scss">
    #workout {
        position: absolute;
        left: 29.5%;
        top: 2%;
        height: 93.8%;
        width: 40%;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        margin: 1rem;
        justify-items: center;
        background-color: white;

        #top {
            display: flex;
            width: 97%;
            justify-content: space-between;
            padding-top: 1rem;
            padding-bottom: 1rem;
            border-bottom: 0.3 rem solid rgb(231, 231, 231);
        }

        #workoutInfo {
            width: 90%;

            #findExercises {
                height: 73rem;
                #chosenExercise {
                    margin: 0;
                    padding: 2rem;
                    p{
                        margin: 0rem;
                    }
                }
            }
            #addExercise {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                gap: 0.5rem;
                p {
                    font-size: medium;
                    font-weight: 600;
                    font-family: "DM sans", sans-serif;
                }
                img {
                    width: 3rem;
                }
            }
        }
    }

    #search {
        position: absolute;
        background-color: white;
        top: 3rem;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid rgb(214, 214, 214);
        height: 93.8%;
        left: 71%;
        width: 28rem;
        button {
            position: absolute;
            left: 22.3rem;
            margin: 1rem;
        }
    }
</style>
