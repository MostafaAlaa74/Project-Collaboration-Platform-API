<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
</head>

<body
    style="margin:0; padding:0; background-color:#f4f6f8; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <div style="width:100%; padding:30px 0;">
        <div
            style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(16,24,40,0.08);">

            <!-- Header -->
            <div
                style="background: linear-gradient(90deg,#10b981 0%, #06b6d4 100%); padding:28px 20px; text-align:center;">
                <h1 style="color:#ffffff; font-size:22px; margin:0; font-weight:700;">Welcome to {{ config('app.name') }}
                </h1>
                <p style="color: rgba(255,255,255,0.9); margin:8px 0 0; font-size:13px;">Your account has been created
                    successfully</p>
            </div>

            <!-- Body -->
            <div style="padding:28px 30px; color:#0f172a;">
                <p style="margin:0 0 18px 0; font-size:15px; line-height:1.6;">Hi {{ $user->name ?? ($name ?? 'there') }},
                </p>

                <p style="margin:0 0 18px 0; font-size:15px; line-height:1.6; color:#334155;">
                    Thanks for signing up. We're excited to have you on board. Below are a few quick links to help you
                    get started with your projects and collaboration.
                </p>

                <!-- Quick Links -->
                <div style="display:flex; gap:12px; flex-wrap:wrap; margin:18px 0;">
                    <a href="{{ $dashboardUrl ?? config('app.url') }}"
                        style="background:#06b6d4; color:#ffffff; text-decoration:none; padding:10px 16px; border-radius:6px; font-weight:600; font-size:14px; display:inline-block;">Go
                        to Dashboard</a>
                    <a href="{{ $projectsUrl ?? config('app.url') . '/projects' }}"
                        style="background:#f1f5f9; color:#0f172a; text-decoration:none; padding:10px 16px; border-radius:6px; font-weight:600; font-size:14px; display:inline-block; border:1px solid #e2e8f0;">View
                        Projects</a>
                </div>

                <!-- Info Box -->
                <div
                    style="background:#f8fafc; border-left:4px solid #06b6d4; padding:16px; border-radius:6px; margin:20px 0;">
                    <p style="margin:0; font-weight:600; color:#0f172a; font-size:14px;">Quick Tips</p>
                    <ul style="margin:8px 0 0 18px; color:#334155; font-size:14px; line-height:1.6;">
                        <li>Complete your profile to help teammates recognize you.</li>
                        <li>Create or join a project to start collaborating.</li>
                        <li>Use notifications to stay updated on changes.</li>
                    </ul>
                </div>

                <p style="margin:0 0 18px 0; color:#475569; font-size:14px;">If you have any questions, reply to this
                    email or contact our support.</p>

                <p style="margin:0 0 0 0; color:#7b8794; font-size:13px;">Welcome aboard,<br>{{ config('app.name') }}
                    Team</p>
            </div>

            <!-- Footer -->
            <div
                style="background:#fbfdff; padding:16px 20px; border-top:1px solid #eef2f7; text-align:center; font-size:12px; color:#94a3b8;">
                <p style="margin:0 0 6px 0;">© {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin:0;">This message was sent to you because you created an account at
                    {{ config('app.name') }}.</p>
            </div>
        </div>
    </div>
</body>

</html>
