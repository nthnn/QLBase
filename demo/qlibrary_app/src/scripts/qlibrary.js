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

$("#book-thumbnail").on("change", (e)=> {
    if(!e.target.files.length) {
        $("#thumbnail").attr("src", "");
        return;
    }

    $("#thumbnail").attr("src", URL.createObjectURL(e.target.files.item(0)));
    $("#thumbnail").removeClass("d-none");
    $("#thumbnail").addClass("d-block");
});

$("#uploadModal").on("hidden.bs.modal", ()=> {
    $("#upload-form").trigger("reset");

    $("#thumbnail").attr("src", "");
    $("#thumbnail").removeClass("d-block");
    $("#thumbnail").addClass("d-none");
});

$("#upload").on("click", () => {
    const formData = new FormData();
    formData.append("name", "books");

    $.ajax({
        url: Environment.action("db_get_by_name"),
        type: "POST",
        headers: {
            "QLBase-API-Key": Environment.key,
            "QLBase-App-ID": Environment.id
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: (data) => {
            const bookTitle = $("#book-title").val(),
                bookDesc = $("#book-desc").val();

                
            const uploadPdfData = new FormData();
            uploadPdfData.append(
                "subject",
                document.querySelector("#book-pdf").files[0]
            );

            $.ajax({
                url: Environment.action("file_upload"),
                type: "POST",
                headers: {
                    "QLBase-API-Key": Environment.key,
                    "QLBase-App-ID": Environment.id
                },
                data: uploadPdfData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: (pdfUpRes) => {
                    if(pdfUpRes.result === "1") {
                        const ticketData = new FormData();
                        ticketData.append("name", pdfUpRes.value);
                        ticketData.append("should_expire", 0);

                        $.ajax({
                            url: Environment.action("file_download"),
                            type: "POST",
                            headers: {
                                "QLBase-API-Key": Environment.key,
                                "QLBase-App-ID": Environment.id
                            },
                            data: ticketData,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            success: (pdfTicket) => {
                                const uploadThumbnailData = new FormData();
                                uploadThumbnailData.append(
                                    "subject",
                                    document.querySelector("#book-thumbnail").files[0]
                                );

                                $.ajax({
                                    url: Environment.action("file_upload"),
                                    type: "POST",
                                    headers: {
                                        "QLBase-API-Key": Environment.key,
                                        "QLBase-App-ID": Environment.id
                                    },
                                    data: uploadThumbnailData,
                                    contentType: false,
                                    processData: false,
                                    dataType: "json",
                                    success: (res) => {
                                        if(res.result === "1") {
                                            const ticketData = new FormData();
                                            ticketData.append("name", res.value);
                                            ticketData.append("should_expire", 0);

                                            $.ajax({
                                                url: Environment.action("file_download"),
                                                type: "POST",
                                                headers: {
                                                    "QLBase-API-Key": Environment.key,
                                                    "QLBase-App-ID": Environment.id
                                                },
                                                data: ticketData,
                                                contentType: false,
                                                processData: false,
                                                dataType: "json",
                                                success: (ticketRes) => {
                                                    const db = data.value[1];
                                                    db[bookTitle] = [bookDesc, ticketRes.value, pdfTicket.value];
                                                    formData.append("content", btoa(JSON.stringify(db)));

                                                    $.ajax({
                                                        url: Environment.action("db_write"),
                                                        type: "POST",
                                                        headers: {
                                                            "QLBase-API-Key": Environment.key,
                                                            "QLBase-App-ID": Environment.id
                                                        },
                                                        data: formData,
                                                        contentType: false,
                                                        processData: false,
                                                        dataType: "json",
                                                        success: (result) => {
                                                            $("#uploadModal").modal("toggle");
                                                            $("#uploadSuccessModal").modal("toggle");
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }
    });
});

const renderBookCard = (title, description, thumbnail, pdf)=> {
    let contents = "<div class=\"col-lg-3\"><div class=\"card border-secondary mb-3\">";
    contents += "<div class=\"card-header\">" + title + "</div>";
    contents += "<div class=\"card-body\"><p class=\"card-text\">" +
        description + "<a target=\"_blank\" href=\"" + Environment.cdp(pdf) +
        "\" class=\"btn btn-outline-primary w-100 mt-2\">Download</a></p></div>";
    contents += "<img src=\"" + Environment.cdp(thumbnail) + "\" class=\"card-img-bottom\" />"
    contents += "</div></div>";

    return contents;
};

let prevData = null;
const updateAvailableBooks = ()=> {
    let formData = new FormData();
    formData.append("name", "books");

    $.ajax({
        url: Environment.action("db_read"),
        type: "POST",
        headers: {
            "QLBase-API-Key": Environment.key,
            "QLBase-App-ID": Environment.id
        },
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: (data)=> {
            $("#loading-view").addClass("d-none");
            if(prevData == JSON.stringify(data))
                return;

            const bookList = $("#book-list");
            bookList.html("");
            prevData = JSON.stringify(data);

            if(Object.keys(data.value).length == 0) {
                $("#no-books-yet").removeClass("d-none");
                $("#no-books-yet").addClass("d-block");

                return;
            }
            else {
                $("#no-books-yet").removeClass("d-block");
                $("#no-books-yet").addClass("d-none");
            }

            let content = "<div class=\"row\">", count = 0;
            for(const [key, values] of Object.entries(data.value)) {
                if(count == 4) {
                    count = 0;
                    content += "</div><div class=\"row\">";
                }

                content += renderBookCard(key, values[0], values[1], values[2]);
                count++;
            }

            content += "</div>";
            bookList.append(content);
            bookList.removeClass("d-none");
            bookList.addClass("d-block");
        }
    });
};

setInterval(updateAvailableBooks, 500);