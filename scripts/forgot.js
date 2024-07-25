/*
 * This file is part of QLBase (https://github.com/nthnn/QLBase).
 * Copyright 2024 - Nathanne Isip
 * 
 * Permission is hereby granted, free of charge,
 * to any person obtaining a copy of this software
 * and associated documentation files (the “Software”),
 * to deal in the Software without restriction,
 * including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to
 * whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions
 * of the Software.
 * 
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF
 * ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT
 * SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR
 * ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

const showMessage = (id, message)=> {
    $(id).removeClass("d-none");
    $(id).addClass("d-block");
    $(id).html(message);
};

const hideMessage = (id)=> {
    $(id).removeClass("d-block");
    $(id).addClass("d-none");
};

$(document).ready(()=> {
    const forgotBtn = RotatingButton("#forgot-btn");

    $("#forgot-btn").click(()=> {
        let ue = $("#ue").val();

        hideMessage("#ue-error");
        hideMessage("#ue-success");
        forgotBtn.show();

        if(!ue ||
            ue === "" ||
            (!/^[a-zA-Z0-9_]+$/.test(ue) &&
            !/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(ue))) {
            showMessage("#ue-error", "Invalid username or email.");
            forgotBtn.hide();
            return;
        }

        $.post(
            "side/forgetpass.php",
            { ue: ue },
            (data)=> {
                forgotBtn.hide();

                if(data.result == "1")
                    showMessage("#ue-success", "Recovery email was sent.");
                else showMessage("#ue-error", data.message);
            }
        )
    });
});