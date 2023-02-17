<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./favicon.ico" />
    <link rel="icon" type="image/png" href="./favicon.png" />
    <link rel="stylesheet" href="/build/css/style.css" />
    <title>Document</title>
</head>

<body>
    <div x-data="users_table()">
        <div class="container relative  min-h-screen m-auto my-3 sm:my-10 max-w-screen-desktop">
            <div id="user__list">
                <div class="px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Пользователи</h1>
                            <p class="mt-2 text-sm text-gray-700">Список всех пользователей в вашей учетной записи,
                                включая
                                их имя, должность</p>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <button @click="add_new_user()" type="button"
                                class="block rounded-md bg-blue-600 py-1.5 px-3 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Добавить</button>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Имя</th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                                                Фамилия
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                                                Должность
                                            </th>

                                            <th scope="col" class="relative py-3.5 pl-3 pr-6 sm:pr-0">
                                                <span class="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <template x-if="users">
                                        <tbody class="divide-y divide-gray-200">
                                            <template x-for="user in users">
                                                <tr>
                                                    <td x-text="user.first_name"
                                                        class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                                        Lindsay</td>
                                                    <td x-text="user.last_name"
                                                        class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">Walton
                                                    </td>
                                                    <td x-text="user.position"
                                                        class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                                        Front-end
                                                        Developer</td>
                                                    <td
                                                        class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium sm:pr-0">
                                                        <div class="inline-flex gap-4 items-end items-center self-end">
                                                            <button @click="edit_user(user.id)"
                                                                class="text-blue-600 hover:text-blue-900">Редактировать<span
                                                                    class="sr-only">, Lindsay Walton</span></button>

                                                            <button type="button"
                                                                @click="delete_user(user.id).then(()=>{refresh_users_data()})"
                                                                class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                                <span class="sr-only">remove</span>
                                                                <!-- Heroicon name: outline/x-mark -->
                                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" aria-hidden="true">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </template>
                                            <!-- More people... -->
                                        </tbody>
                                    </template>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div x-cloak="" @keydown.window.escape="form_params.show = false" x-show="form_params.show"
            class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!--
    Background backdrop, show/hide based on modal state.

    Entering: "ease-out duration-300"
      From: "opacity-0"
      To: "opacity-100"
    Leaving: "ease-in duration-200"
      From: "opacity-100"
      To: "opacity-0"
  -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!--
        Modal panel, show/hide based on modal state.

        Entering: "ease-out duration-300"
          From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          To: "opacity-100 translate-y-0 sm:scale-100"
        Leaving: "ease-in duration-200"
          From: "opacity-100 translate-y-0 sm:scale-100"
          To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      -->
                    <div @click.away="form_params.show = false"
                        class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                        <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                            <button type="button" @click="form_params.show = false;"
                                class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: outline/x-mark -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form x-data="user_form($el)"
                            @submit.prevent="send_data($el).then(()=>{form_params.show = false; refresh_users_data()})"
                            class="w-full max-w-lg mx-auto pt-5" action="" id="user_form">
                            <div x-init="$watch('form_params.show', (value) => {set_user_data(form_params.user,form_params.method)} )"
                                class="flex flex-wrap -mx-3 mb-6">
                                <input type="hidden" name="user_id" x-model="user_id">
                                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-first-name">
                                        Имя
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                        name="first_name" x-model="first_name" type="text" placeholder="Jane">
                                    <!-- <p class="text-red-500 text-xs italic">Please fill out this field.</p> -->
                                </div>
                                <div class="w-full md:w-1/2 px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-last-name">
                                        Фамилия
                                    </label>
                                    <input
                                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        type="text" placeholder="Doe" name="last_name" x-model="last_name">
                                </div>
                            </div>
                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="grid-state">
                                        Должность
                                    </label>
                                    <div class="relative">
                                        <select name="position" x-model="position"
                                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 bg-none py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                            <option value="">Сделайте выбор</option>
                                            <option value="Программист">Программист</option>
                                            <option value="Менеджер">Менеджер</option>
                                            <option value="Тестировщик">Тестировщик</option>
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script defer src="./build/js/app.js"></script>
</body>

</html>