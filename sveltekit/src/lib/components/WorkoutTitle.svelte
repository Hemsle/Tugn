<script>
    import { workout } from "$lib/stores/workoutStore.js";

    let editName = $state(false);

    function toggle() {
        editName = !editName;
    }

    function nameChange(e) {
        workout.update((w) => {
            w.name = e.target.value;
            return w;
        });
    }

    function enter(e) {
        if (e.key === "Enter") {
            empty(e);
            editName = false;
        }
    }

    function onBlur(e) {
        empty(e);
        editName = false;
    }

    function empty(e) {
        if (!e.target.value) {
            workout.update((w) => {
                w.name = "Workout";
                return w;
            });
        }
    }
</script>

<div class="title-container">
    {#if editName}
        <input
            type="text"
            value={$workout.name}
            oninput={nameChange}
            onkeydown={enter}
            onblur={onBlur}
            autofocus
        />
    {:else}
        <h1>{$workout.name}</h1>
    {/if}

    {#if !editName}
        <button onclick={toggle}><img src="/icons/edit.png" alt="pen" /></button
        >
    {/if}
</div>

<style lang="scss">
    .title-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;

        input {
            font-size: 2rem;
            font-weight: bold;
            font-family: inherit;
            border: none;
            border-bottom: solid 0.1rem var(--third);
            text-align: center;
            outline: none;
        }

        h1 {
            margin-left: 3.5rem;
        }

        button {
            display: flex;
            align-items: center;
            height: 100%;
            flex-shrink: 0;
            img {
                width: 2rem;
                opacity: 0.6;
            }
        }
    }
</style>
