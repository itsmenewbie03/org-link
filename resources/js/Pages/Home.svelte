<script>
    export let user;
</script>

<svelte:head>
    <title>Welcome, {user}</title>
</svelte:head>
<h1 class="text-blue-500 text-3xl text-center">Welcome</h1>
<p class="text-2xl text-center">
    Hello {user}, welcome to your first Inertia app!
</p>
<div class="w-full flex justify-center mt-2">
    <button class="btn btn-primary w-1/2">I am a useless buttton.</button>
</div>
