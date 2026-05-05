import { Head, Link, useForm } from '@inertiajs/react';

const APP_NAME = 'Fan Company Management Software';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email:    '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), { onFinish: () => reset('password') });
    };

    return (
        <>
            <Head title="Log in" />

            <div className="min-h-screen flex bg-gradient-to-br from-slate-900 via-purple-950 to-indigo-950">

                {/* ===== Left branding panel â€“ desktop ===== */}
                <div className="hidden lg:flex lg:w-1/2 flex-col justify-between p-12 relative overflow-hidden">

                    {/* decorative blobs */}
                    <div className="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-purple-700/20 blur-3xl pointer-events-none" />
                    <div className="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-indigo-700/20 blur-3xl pointer-events-none" />
                    <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 rounded-full bg-violet-800/10 blur-3xl pointer-events-none" />

                    {/* Logo row */}
                    <div className="relative z-10 flex items-center gap-3">
                        <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center font-bold text-xl text-white shadow-lg">
                            {APP_NAME.charAt(0)}
                        </div>
                        <span className="text-white font-semibold text-lg">{APP_NAME}</span>
                    </div>

                    {/* Headline block */}
                    <div className="relative z-10">
                        <h1 className="text-4xl font-extrabold text-white leading-tight mb-5">
                            Welcome back to{' '}
                            <span className="bg-gradient-to-r from-purple-300 to-indigo-300 bg-clip-text text-transparent">
                                {APP_NAME}
                            </span>
                        </h1>
                        <p className="text-slate-400 text-lg leading-relaxed mb-8">
                            Sign in to access your dashboard and manage everything in one place.
                        </p>

                        <div className="flex flex-wrap gap-6">
                            {[
                                ['Secure Login',   'shield'],
                                ['Instant Access', 'bolt'  ],
                                ['Live Data',      'chart' ],
                            ].map(([lbl]) => (
                                <div
                                    key={lbl}
                                    className="flex items-center gap-2 text-sm text-slate-400"
                                >
                                    <span className="w-1.5 h-1.5 rounded-full bg-purple-400 inline-block" />
                                    {lbl}
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Footer text */}
                    <div className="relative z-10 text-xs text-slate-600">
                        &copy; {new Date().getFullYear()} {APP_NAME}. All rights reserved.
                    </div>
                </div>

                {/* ===== Right form panel ===== */}
                <div className="flex-1 flex items-center justify-center p-6">
                    <div className="w-full max-w-md">

                        {/* Mobile logo */}
                        <div className="lg:hidden flex items-center gap-2 mb-8">
                            <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center font-bold text-white shadow-lg">
                                {APP_NAME.charAt(0)}
                            </div>
                            <span className="text-white font-semibold text-base">{APP_NAME}</span>
                        </div>

                        {/* Card */}
                        <div className="backdrop-blur-sm bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">

                            <div className="mb-8">
                                <h2 className="text-2xl font-bold text-white mb-1">Sign in</h2>
                                <p className="text-slate-400 text-sm">Enter your credentials to continue</p>
                            </div>

                            {/* Success / info status */}
                            {status && (
                                <div className="mb-6 rounded-xl bg-green-500/10 border border-green-500/20 px-4 py-3 text-sm text-green-400">
                                    {status}
                                </div>
                            )}

                            <form onSubmit={submit} className="space-y-5">

                                {/* Email */}
                                <div>
                                    <label
                                        htmlFor="email"
                                        className="block text-sm font-medium text-slate-300 mb-1.5"
                                    >
                                        Email address
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value={data.email}
                                        autoComplete="username"
                                        autoFocus
                                        placeholder="you@example.com"
                                        onChange={(e) => setData('email', e.target.value)}
                                        className="w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                    />
                                    {errors.email && (
                                        <p className="mt-1.5 text-xs text-red-400">{errors.email}</p>
                                    )}
                                </div>

                                {/* Password */}
                                <div>
                                    <div className="flex items-center justify-between mb-1.5">
                                        <label
                                            htmlFor="password"
                                            className="text-sm font-medium text-slate-300"
                                        >
                                            Password
                                        </label>
                                        {canResetPassword && (
                                            <Link
                                                href={route('password.request')}
                                                className="text-xs text-purple-400 hover:text-purple-300 transition"
                                            >
                                                Forgot password?
                                            </Link>
                                        )}
                                    </div>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        autoComplete="current-password"
                                        placeholder="Enter your password"
                                        onChange={(e) => setData('password', e.target.value)}
                                        className="w-full rounded-xl bg-white/5 border border-white/10 text-white placeholder-slate-500 px-4 py-3 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                                    />
                                    {errors.password && (
                                        <p className="mt-1.5 text-xs text-red-400">{errors.password}</p>
                                    )}
                                </div>

                                {/* Remember me */}
                                <div className="flex items-center gap-2.5">
                                    <input
                                        type="checkbox"
                                        id="remember"
                                        name="remember"
                                        checked={data.remember}
                                        onChange={(e) => setData('remember', e.target.checked)}
                                        className="w-4 h-4 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500 focus:ring-offset-0 cursor-pointer"
                                    />
                                    <label
                                        htmlFor="remember"
                                        className="text-sm text-slate-400 cursor-pointer select-none"
                                    >
                                        Keep me signed in
                                    </label>
                                </div>

                                {/* Submit */}
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 disabled:opacity-60 disabled:cursor-not-allowed transition font-semibold text-white text-sm shadow-lg shadow-purple-900/30 mt-1"
                                >
                                    {processing ? 'Signing in...' : 'Sign in'}
                                </button>
                            </form>

                            <p className="mt-6 text-center text-sm text-slate-500">
                                Don&apos;t have an account?{' '}
                                <Link
                                    href={route('register')}
                                    className="text-purple-400 hover:text-purple-300 font-medium transition"
                                >
                                    Create one
                                </Link>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </>
    );
}