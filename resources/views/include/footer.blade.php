
            <footer>
                <div class="container">
                    <a target="_blank" href="https://icons8.com/icon/p4rXi9HURgXT/help">иконки</a> от <a target="_blank" href="https://icons8.com">Icons8</a>
                    <a href="https://www.flaticon.com/free-icons/moon" title="moon icons">Moon icons created by Good Ware - Flaticon</a>
                    <a href="https://www.flaticon.com/free-icons/sun" title="sun icons">Sun icons created by Freepik - Flaticon</a>

                    <div class="mt-5">
                        <div class="copyright text-center">{{ __('develop by ') }}<a href="https://github.com/chokoladis">{{ config('app.develop.name') }}</a>{{ __(' / 2024 y.') }}</div>
                    </div>
                </div>
            </footer>
        </div>    
        @vite(['resources/js/jquery.min.js', 'resources/js/app.js'])
        @stack('script')
    </body>
</html>