<div>
    <section class="w-full overflow-hidden">
        <div class="flex flex-col">
            <!-- Cover Image -->
            <img src="{{ asset('img/home-bg.jpg') }}"
                alt="User Cover" class="w-full xl:h-[20rem] lg:h-[18rem] md:h-[16rem] sm:h-[14rem] h-[11rem]" />

            <!-- Profile Image -->
            <div class="sm:w-[80%] w-[90%] mx-auto flex">
                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->username) . '&background=1E88E5&color=fff' }}"
                    alt="{{ Auth::user()->username }}"
                    class="rounded-md lg:w-[12rem] lg:h-[12rem] md:w-[10rem] md:h-[10rem] sm:w-[8rem] sm:h-[8rem] w-[7rem] h-[7rem] outline outline-2 outline-offset-2 outline-blue-500 relative lg:bottom-[5rem] sm:bottom-[4rem] bottom-[3rem]" />

                <!-- FullName -->
                <h1
                    class="w-full text-left my-4 sm:mx-4 pl-4 text-gray-800 dark:text-highlight lg:text-4xl md:text-3xl sm:text-3xl text-xl font-serif">
                    Samuel Abera</h1>

            </div>

            <div
                class="xl:w-[80%] lg:w-[90%] md:w-[90%] sm:w-[92%] w-[90%] mx-auto flex flex-col gap-4 items-center relative lg:-top-8 md:-top-6 -top-4">
                <!-- Description -->
                <p class="w-fit text-gray-700 dark:text-gray-400 text-md">Lorem, ipsum dolor sit amet
                    consectetur adipisicing elit. Quisquam debitis labore consectetur voluptatibus mollitia dolorem
                    veniam omnis ut quibusdam minima sapiente repellendus asperiores explicabo, eligendi odit, dolore
                    similique fugiat dolor, doloremque eveniet. Odit, consequatur. Ratione voluptate exercitationem hic
                    eligendi vitae animi nam in, est earum culpa illum aliquam.</p>

                <!-- Detail -->
                <div class="w-full my-auto py-6 flex flex-col justify-center gap-2">
                    <div class="w-full flex sm:flex-row flex-col gap-2 justify-center">
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">First Name</dt>
                                    <dd class="text-lg font-semibold">Samuel</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Last Name</dt>
                                    <dd class="text-lg font-semibold">Abera</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Date Of Birth</dt>
                                    <dd class="text-lg font-semibold">14/05/1977</dd>
                                </div>
                                <div class="flex flex-col py-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Gender</dt>
                                    <dd class="text-lg font-semibold">Male</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="w-full">
                            <dl class="text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                                <div class="flex flex-col pb-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Location</dt>
                                    <dd class="text-lg font-semibold">Ethiopia, Addis Ababa</dd>
                                </div>

                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Phone Number</dt>
                                    <dd class="text-lg font-semibold">+251913****30</dd>
                                </div>
                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Email</dt>
                                    <dd class="text-lg font-semibold">samuel@example.com</dd>
                                </div>

                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Website</dt>
                                    <dd class="text-lg font-semibold hover:text-blue-500"><a
                                            href="https://techakim.com">https://www.teclick.com</a></dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>

                <!-- Social Links -->
                <div
                    class="fixed right-2 bottom-20 flex flex-col rounded-sm bg-gray-200 text-gray-500 dark:bg-gray-200/80 dark:text-gray-700 hover:text-gray-600 hover:dark:text-gray-400">
                    <a href="https://www.linkedin.com/in/samuel-abera-6593a2209/">
                        <div class="p-2 hover:text-primary hover:dark:text-primary">
                            <svg class="lg:w-6 lg:h-6 w-4 h-4 text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z"
                                    clip-rule="evenodd" />
                                <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                            </svg>

                        </div>
                    </a>
                    <a href="https://twitter.com/Samuel7Abera7">
                        <div class="p-2 hover:text-primary hover:dark:text-primary">
                            <svg class="lg:w-6 lg:h-6 w-4 h-4 text-gray-900" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M13.795 10.533 20.68 2h-3.073l-5.255 6.517L7.69 2H1l7.806 10.91L1.47 22h3.074l5.705-7.07L15.31 22H22l-8.205-11.467Zm-2.38 2.95L9.97 11.464 4.36 3.627h2.31l4.528 6.317 1.443 2.02 6.018 8.409h-2.31l-4.934-6.89Z" />
                            </svg>

                        </div>
                    </a>
                    <a href="">
                        <div class="p-2 hover:text-blue-500 hover:dark:text-blue-500">
                            <svg class="lg:w-6 lg:h-6 w-4 h-4 text-blue-700" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                    <a href="https://www.youtube.com/@silentcoder7">
                        <div class="p-2 hover:text-primary hover:dark:text-primary">
                            <svg class="lg:w-6 lg:h-6 w-4 h-4 text-red-600" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>
</div>
