<script setup lang="ts">
import { RouterLink } from "vue-router";
</script>

<template>
    <br/>
    <center>
        <img src="@/assets/qlbase-logo.png" width="200"/>
        <br/><br/>
        <h1 class="border-bottom">QLBase</h1>
    </center>

    <p class="badges">
        <img src="https://github.com/nthnn/QLBase/actions/workflows/php-syntax-check.yml/badge.svg" class="pr-1" alt="PHP Syntax Check" />
        <img src="https://github.com/nthnn/QLBase/actions/workflows/backend.yml/badge.svg" class="px-1" alt="Backend Workflow" />
        <img src="https://github.com/nthnn/QLBase/actions/workflows/vue-docs.yml/badge.svg" class="px-1" alt="Vue Docs CI" />
        <img src="https://img.shields.io/github/issues/nthnn/QLBase.svg" class="px-1" alt="GitHub Issues" />
        <img src="https://img.shields.io/github/stars/nthnn/QLBase.svg" class="px-1" alt="GitHub Stars" />
        <img src="https://img.shields.io/badge/license-GPL-blue.svg" class="px-1" alt="License" />
        <img src="https://img.shields.io/badge/license-MIT-blue.svg" class="px-1" alt="License" />
        <img src="https://img.shields.io/badge/license-CERN-blue.svg" class="pl-1" alt="License" />
    </p>
    <br/>

    <h3 class="border-bottom">🪁 What is QLBase?</h3>
    <p>QLBase is a powerful open-source decentralizable backend solution designed to provide scalable and reliable services for a wide range of applications. It offers a comprehensive set of features including user account authentication, SMS verification via OTP (One-Time Password), data analytics, database storage, file storage, and even machine learning as a software service. QLBase aims to be a flexible alternative to traditional cloud-based services, empowering developers to build robust applications with ease.</p>
    <br/>

    <h3 class="border-bottom">🎯 Features</h3>
    <p>QLBase offers a wide array of features that make it a versatile, scalable, reliable, and powerful backend solution suitable for a variety of applications. Below are the summarized APIs and service features of QLBase:</p>
    <ul>
        <li><b>Authentication</b>: QLBase provides a robust authentication system that allows you to manage user accounts securely.</li>
        <li><b>SMS Verification</b>: Easily integrate SMS verification into your application using QLBase's OTP service. Protect your user accounts with one-time passwords sent via SMS. QLBase provides SMS verification functionality using an Arduino UNO with a SIM900 Shield as the underlying SMS hardware.</li>
        <li><b>Data Analytics</b>: QLBase includes powerful data analytics capabilities, enabling you to identify, track, and page data efficiently. QLBase offers data analytics identification, tracking, paging, and even making aliases for both registered users and anonymous guess.</li>
        <li><b>Database</b>: Store and manage your data in QLBase's scalable and reliable database storage. Key features of QLBase's database storage include</li>
        <li><b>File Storage</b>: QLBase simplifies file management within your application. QLBase file storage API service offers: file uploads, file retrievals, and access controls.</li>
        <li><b>Machine Learning</b>: Leverage machine learning as a software service through QLBase. Integrate AI capabilities into your applications without the hassle of managing complex infrastructure. QLBase's machine learning features inclues model integration, custom model training, and scalable infrastructure.</li>
    </ul>
    <br/>

    <h3 class="border-bottom">💙 Donating</h3>
    <p>QLBase is an open-source project and is voluntarily developed. If you find QLBase useful and would like to support its continued development and improvement, you can make a donation.</p>

    <table align="center">
        <tr>
            <td class="p-4"><a href="https://paypal.me/nathannestein" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="Donate with PayPal"></a></td>
            <td class="p-4"><a href="https://www.buymeacoffee.com/nthnn" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee"></a></td>
        </tr>
    </table>

    <br/>
    <p>QLBase developers are profoundly grateful for your support! Your generosity allows us to continue developing and maintaining QLBase, making it better with each update. Your contribution is not just a donation; it's a vote of confidence in the project and a testament to the strength of the open-source community. Your contribution will help cover fund new features and support the community and developers (?) behind QLBase.</p>

    <hr/>
    <div class="row">
        <div class="col-6">
            <button class="alert alert-warning p-2 w-auto">
                Note: QLBase is a work-in-progress.
            </button>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/deployment" class="btn btn-primary">
                    Deployment

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>