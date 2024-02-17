<script>
    export let user;
    import { Toaster, toast } from "svelte-french-toast";
    const greet_user = () => {
        toast(`Hello, ${user}`, {
            icon: "👋",
        });
    };
</script>

<svelte:head>
    <title>Hello, {user}</title>
</svelte:head>
<Toaster />
<div
    class="h-screen w-full flex flex-col justify-center items-center align-middle"
>
    <h1 class="text-3xl">
        Welcome, {user}
    </h1>
    <button class="btn btn-primary w-1/2 mt-3" on:click={greet_user}
        >Greet Me!</button
    >
</div>
