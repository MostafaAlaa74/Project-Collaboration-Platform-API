<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Created</title>
</head>

<body
    style="margin:0; padding:0; background:#f4f6f8; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;">
    <div style="width:100%; padding:24px 0;">
        <div
            style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(2,6,23,0.08);">
            <div
                style="background:linear-gradient(90deg,#3b82f6 0%,#6366f1 100%); padding:24px 20px; text-align:center;">
                <h2 style="color:#fff; margin:0; font-size:20px;">New Task Added to "{{ $project->name ?? 'Project' }}"
                </h2>
                <p style="color:rgba(255,255,255,0.9); margin:8px 0 0; font-size:13px;">A new task has been created —
                    stay in the loop.</p>
            </div>

            <div style="padding:20px 24px; color:#0f172a;">
                <p style="margin:0 0 12px 0;">Hello,</p>

                <p style="margin:0 0 12px 0; color:#334155; font-size:14px; line-height:1.6;">
                    A new task was created in the project <strong>{{ $project->name ?? '—' }}</strong> by
                    <strong>{{ $task->creator->name ?? ($project->owner->name ?? 'Project Owner') }}</strong>.
                </p>

                <div
                    style="background:#f8fafc; border-left:4px solid #3b82f6; padding:14px; border-radius:6px; margin:12px 0;">
                    <p style="margin:0 0 8px 0; font-weight:600;">Task:</p>
                    <p style="margin:0; color:#334155;"><strong>{{ $task->title }}</strong></p>

                    <p style="margin:8px 0 0 0; color:#475569; font-size:13px;">Priority:
                        {{ ucfirst($task->priority ?? 'normal') }} • Status:
                        {{ ucfirst(str_replace('_', ' ', $task->status ?? 'pending')) }}</p>
                </div>

                <div style="text-align:center; margin:18px 0;">
                    <a href="{{ config('app.url') . '/projects/' . ($project->id ?? '') }}"
                        style="display:inline-block; background:#3b82f6; color:#fff; padding:10px 18px; text-decoration:none; border-radius:6px; font-weight:600;">View
                        Project</a>
                </div>

                <p style="margin:0; color:#6b7280; font-size:13px;">You are receiving this email because you are a
                    member or owner of this project.</p>
            </div>

            <div
                style="background:#fbfdff; padding:12px 18px; border-top:1px solid #eef2f7; text-align:center; font-size:12px; color:#94a3b8;">
                <p style="margin:0;">© {{ now()->year }} {{ config('app.name') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
