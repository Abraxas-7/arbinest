import "./bootstrap";
import "~resources/scss/app.scss";
import "~icons/bootstrap-icons.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);

import React from "react";
import ReactDOM from "react-dom/client";
import HelloReact from "./Components/HelloReact.jsx";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<HelloReact />);
