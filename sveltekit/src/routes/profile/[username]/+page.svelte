<script>
    import ProfilePage from "$lib/components/ProfilePage.svelte";
    import { goto } from "$app/navigation";
    let { data } = $props();

    console.log(data);

    // Check om jag hamnat på min egen sida via [username]
    if (data.user?.uid === data.visitedUser?.uid) {
        goto("/profile");
    }
</script>

<ProfilePage 
    data={data}
    isOwnProfile={false} 
/>