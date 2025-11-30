<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Invitation</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f5f5f5;">
    <div style="width: 100%; background-color: #f5f5f5; padding: 20px 0;">
        <!-- Main Container -->
        <div
            style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); overflow: hidden;">

            <!-- Header -->
            <div
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 600;">You're Invited!</h1>
                <p style="color: #e9ecef; margin: 10px 0 0 0; font-size: 14px;">Join us on a collaborative project</p>
            </div>

            <!-- Content -->
            <div style="padding: 40px 30px;">
                <!-- Greeting -->
                <p style="color: #2c3e50; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                    Hello,
                </p>

                <!-- Main Message -->
                <p style="color: #34495e; font-size: 15px; line-height: 1.8; margin: 0 0 20px 0;">
                    You have been invited to join a project collaboration. This is an opportunity to work together with
                    your team and accomplish great things.
                </p>

                <!-- Project Details Box -->
                <div
                    style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 20px; border-radius: 4px; margin: 30px 0;">
                    <p style="color: #2c3e50; font-size: 14px; margin: 0 0 12px 0; font-weight: 600;">Project Details:
                    </p>
                    <p style="color: #555555; font-size: 14px; margin: 8px 0; line-height: 1.6;">
                        <strong>Project Name:</strong> {{ $project->name }}
                    </p>
                    <p style="color: #555555; font-size: 14px; margin: 8px 0; line-height: 1.6;">
                        <strong>Invited by:</strong> {{ $user->name }} ({{ $user->email }})
                    </p>
                    <p style="color: #555555; font-size: 14px; margin: 8px 0; line-height: 1.6;">
                        <strong>Your Role:</strong> Member
                    </p>
                </div>

                <!-- CTA Button -->
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ $acceptUrl }}"
                        style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 14px 40px; border-radius: 6px; font-size: 16px; font-weight: 600; transition: transform 0.2s ease;">
                        Accept Invitation
                    </a>
                </div>

                <!-- Secondary Message -->
                <p style="color: #7f8c8d; font-size: 14px; line-height: 1.6; margin: 30px 0 0 0;">
                    If you have any questions or need more information, feel free to reach out. We're excited to have
                    you on the team!
                </p>
            </div>

            <!-- Footer -->
            <div
                style="background-color: #f8f9fa; padding: 25px 30px; border-top: 1px solid #e9ecef; text-align: center;">
                <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 10px 0; line-height: 1.6;">
                    © 2025 Project Collaboration Platform. All rights reserved.
                </p>
                <p style="color: #95a5a6; font-size: 12px; margin: 0;">
                    This is an automated invitation. Please do not reply to this email.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
