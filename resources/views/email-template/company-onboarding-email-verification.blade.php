<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        <base href="../../" />
		<title>Company onboarding email verification - HrBee</title>
		<meta charset="utf-8" />
		<meta name="description" content="Welcome to HrBee - the simplest HRM" />
		<meta name="keywords" content="Hrm, HrBee, employee management" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Company onboarding email verification - HrBee" />
		<meta property="og:url" content="https://hrbee.app" />
		<meta property="og:site_name" content="HrBee by Nonditosoft" />
		<link rel="canonical" href="https://hrbee.app" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank">
		<!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		<!--end::Theme mode setup on page load-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
				<!--begin::Body-->
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
                    <style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
                    <div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
                        <div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
                                <tbody>
                                    <tr>
                                        <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
                                            <!--begin:Email content-->
                                            <div style="text-align:center; margin:0 15px 34px 15px">
                                                <!--begin:Logo-->
                                                <div style="margin-bottom: 10px">
                                                    <h1>{{ $company['name'] }}</h1>
                                                </div>
                                                <!--end:Logo-->
                                                <!--begin:Media-->
                                                {{-- <div style="margin-bottom: 15px">
                                                    <img alt="Logo" src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('assets/media/email/icon-positive-vote-1.svg'))) }}" />
                                                </div> --}}
                                                <!--end:Media-->
                                                <!--begin:Text-->
                                                <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                                                    <h2 style="margin-bottom:9px; font-size: 26px; color:#181C32;">
                                                        Welcome aboard
                                                    </h2>
                                                    <p style="margin-bottom:2px; color:#181C32; font-size: 22px; font-weight:700">Hey {{ $company['name'] }}, thanks for choosing us.</p>
                                                    <div style="color:#7E8299">
                                                        <p>
                                                            Our client-centric solution makes your operations smooth and data secure.
                                                        </p>
                                                        <p>Let’s start an awesome journey!</p>
                                                    </div>
                                                </div>
                                                <!--end:Text-->
                                                <!--begin:Action-->
                                                <a href="{{ $emailVerificationData['email_verification_url'] }}" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; text-decoration: none;">Activate Account</a>
                                                <!--begin:Action-->
                                            </div>
                                            <!--end:Email content-->
                                        </td>
                                    </tr>
                                    <tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
                                        <td align="start" valign="start" style="padding-bottom: 10px;">
                                            <p style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">What’s next?</p>
                                            <!--begin::Wrapper-->
                                            <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
                                                <!--begin::Item-->
                                                <div style="display:flex">
                                                    <!--begin::Media-->
                                                    <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                                        {{-- <img alt="Logo" src="{{ asset('assets/media/email/icon-polygon.svg') }}" /> --}}
                                                        <span style="position: absolute; color:#50CD89; font-size: 16px; font-weight: 600;">1</span>
                                                    </div>
                                                    <!--end::Media-->
                                                    <!--begin::Block-->
                                                    <div>
                                                        <!--begin::Content-->
                                                        <div>
                                                            <!--begin::Title-->
                                                            <a href="#" style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Reset Password</a>
                                                            <!--end::Title-->
                                                            <!--begin::Desc-->
                                                            <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Take the final step to unlock a world of possibilities!</p>
                                                            <!--end::Desc-->
                                                        </div>
                                                        <!--end::Content-->
                                                        <!--begin::Separator-->
                                                        <div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>
                                                        <!--end::Separator-->
                                                    </div>
                                                    <!--end::Block-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div style="display:flex">
                                                    <!--begin::Media-->
                                                    <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                                        {{-- <img alt="Logo" src="{{ asset('assets/media/email/icon-polygon.svg') }}" /> --}}
                                                        <span style="position: absolute; color:#50CD89; font-size: 16px; font-weight: 600;">2</span>
                                                    </div>
                                                    <!--end::Media-->
                                                    <!--begin::Block-->
                                                    <div>
                                                        <!--begin::Content-->
                                                        <div>
                                                            <!--begin::Title-->
                                                            <a href="#" style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Update company settings</a>
                                                            <!--end::Title-->
                                                            <!--begin::Desc-->
                                                            <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Add details about your company.</p>
                                                            <!--end::Desc-->
                                                        </div>
                                                        <!--end::Content-->
                                                        <!--begin::Separator-->
                                                        <div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>
                                                        <!--end::Separator-->
                                                    </div>
                                                    <!--end::Block-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div style="display:flex">
                                                    <!--begin::Media-->
                                                    <div style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                                                        {{-- <img alt="Logo" src="{{ asset('assets/media/email/icon-polygon.svg') }}" /> --}}
                                                        <span style="position: absolute; color:#50CD89; font-size: 16px; font-weight: 600;">3</span>
                                                    </div>
                                                    <!--end::Media-->
                                                    <!--begin::Block-->
                                                    <div>
                                                        <!--begin::Content-->
                                                        <div>
                                                            <!--begin::Title-->
                                                            <a href="#" style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Add Employees</a>
                                                            <!--end::Title-->
                                                            <!--begin::Desc-->
                                                            <p style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">Add employee details and start managing them.</p>
                                                            <!--end::Desc-->
                                                        </div>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Block-->
                                                </div>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="center" style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
                                            <p style="color:#181C32; margin-bottom:9px">We are here 24/7 for you</p>
                                            <p style="margin-bottom:2px"><span>{{ $supportDetails['supportTelephone'] }}</span> | <a href="mailto:{{ $supportDetails['supportEmail'] }}" rel="noopener" target="_blank" style="font-weight: 600">{{ $supportDetails['supportEmail'] }}</a> | <a href="https://hrbee.app/faqs" target="_blank" style="font-weight: 600">FAQ</a></p>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td align="center" valign="center" style="text-align:center; padding-bottom: 20px;">
                                            <a href="#" style="margin-right:10px">
                                                <img alt="Logo" style="height: 50px;" src="{{ asset('media/logos/hrbee-logo.png') }}" />
                                            </a>
                                        </td>
                                    </tr> --}}
                                    <tr>
                                        <td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif; padding-top: 20px;">
                                            <img alt="Logo" style="height: 30px;" src="{{ asset('media/logos/hrbee-logo.png') }}" />
                                            <p>&copy; {{ now()->year }} hr bee</p>
                                            <p><a href="https://hrbee.app" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif">Unsubscribe</a>&nbsp;</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
					<!--end::Email template-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>
