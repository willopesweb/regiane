import { createNotification } from "./notification";

interface Email {
  email: string;
  message: string;
  name: string;
  subject: string;
}

const forms = document.querySelectorAll(".js-form");

if (forms) {
  forms.forEach((form) => {
    form.addEventListener("submit", handleSubmit);
  });
}

async function handleSubmit(this: HTMLElement, e: Event) {
  e.preventDefault();

  const formData = new FormData(e.target as HTMLFormElement);
  const formDataObject: Record<string, string> = {};

  formData.forEach((value, key) => {
    formDataObject[key] = value as string;
  });

  const EmailData: Email = {
    email: formDataObject.Email,
    message: Object.entries(formDataObject)
      .map(([key, value]) => `<b>${key}: </b>${value}<br>`)
      .join(""),
    name: formDataObject.Nome,
    subject:
      this.id === "revisao"
        ? "Você recebeu um novo pedido de orçamento!"
        : `${formDataObject.Nome} enviou uma mensagem pelo site!`,
  };

  console.log(formDataObject);
  console.log(EmailData);
  submitContent(this, EmailData);
}

async function submitContent(form: HTMLElement, EmailData: Email) {
  const loading = form.querySelector(".c-loading");
  loading?.classList.add("is-visible");

  try {
    const result = await sendEmail(EmailData);
    if (result.success) {
      createNotification("E-mail enviado com sucesso!", "success");
    } else {
      createNotification(`Erro ao enviar e-mail: ${result.error}`, "error");
    }
  } catch (error) {
    console.error("Erro na solicitação de envio de e-mail:", error);
    createNotification("Erro ao enviar e-mail", "error");
  }
  loading?.classList.remove("is-visible");
}

async function sendEmail(
  formData: Email
): Promise<{ success: boolean; error?: string }> {
  try {
    const response = await fetch(`${window.location.origin}/wp-send-mail.php`, {
      method: "POST",
      body: JSON.stringify(formData),
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (response.ok) {
      return { success: true };
    } else {
      const errorResponse = await response.json();
      return {
        success: false,
        error: errorResponse.message || "Erro desconhecido",
      };
    }
  } catch (error) {
    console.error("Erro na solicitação de envio de e-mail:", error);
    return { success: false, error: "Erro desconhecido" };
  }
}
