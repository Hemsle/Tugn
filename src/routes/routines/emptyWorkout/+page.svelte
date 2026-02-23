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
        showLibrary,
    } from "$lib/stores/exerciseStore.js"; //addExercises true menar att man väljer övningar från library

    let { data } = $props();

    function close() {
        goto("/routines");
    }

    function back() {
        if ($filteredExercises.length > 0) {
            searched.set(true);
        }

        selectedExercise.set(null);
    }
</script>

<div class="content">
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
                {#if $searched && $showLibrary}
                    <Searched />
                {:else if $selectedExercise}
                    <div id="chosenExercise">
                        <button onclick={back}>Back</button>
                        <h1>{$selectedExercise.name}</h1>
                        <h3>
                            Muscle: {formatOption($selectedExercise.muscle)}
                        </h3>
                        <h3>
                            Equipments: {$selectedExercise.equipments
                                .map((e) => formatOption(e))
                                .join(", ")}
                        </h3>
                        <h3>Type: {formatOption($selectedExercise.type)}</h3>
                        <h3>
                            Difficulty: {formatOption(
                                $selectedExercise.difficulty,
                            )}
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
                    showLibrary.set(true);
                }}
                id="addExercise"
            >
                <img src="/icons/plus.png" alt="plus" />
                <p>Add Exercise</p>
            </button>
        </section>
    </section>

    <div id="library">
        {#if $showLibrary === true}
            <section id="search">
                <Library {data} />
            </section>
        {/if}
    </div>
</div>

<style lang="scss">
    .content {
        display: flex;
        -webkit-box-pack: center;
        max-width: 106rem;
        width: 100%;
        padding: 24px;
        gap: 24px;
        align-items: flex-start;
        flex-direction: row;
        justify-content: flex-end;
    }
    #workout {
        background-color: white;
        max-width: 63rem;
        width: 100%;
        height: 99.8%;
        border: 0.1rem solid rgb(231, 231, 231);
        border-radius: 1.5rem;
        border-bottom: 0.3rem solid rgb(214, 214, 214);
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
                    p {
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

    #library {
        width: 28rem;
        #search {
            background-color: white;
            border: 0.1rem solid rgb(231, 231, 231);
            border-radius: 1.5rem;
            border-bottom: 0.3rem solid rgb(214, 214, 214);
            width: 28rem;
            height: 94.7vh;
            button {
                position: relative;
                left: 22.3rem;
                margin: 1rem;
            }
        }
    }
</style>
