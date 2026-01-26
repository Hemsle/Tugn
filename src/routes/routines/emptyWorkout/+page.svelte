<!--routes/emptyWorkout/+page.svelte-->
<script>
    import { goto } from "$app/navigation";

    import Library from "$lib/components/Library.svelte";
    import { addExercises } from "$lib/stores/exerciseStore.js"; //addExercises true menar att man väljer övningar från library

    export let data;

    let showLibrary = false;

    function close() {
        goto("/routines");
    }

    function toggleLibrary() {
        showLibrary = !showLibrary;
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
        left: 33%;
        top: 2%;
        height: 80%;
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
        left: 75%;
        width: 28rem;
        button {
            position: absolute;
            left: 22.3rem;
            margin: 1rem;
        }
    }
</style>
