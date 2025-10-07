import { Hono } from "hono";
import { zValidator } from "@hono/zod-validator";
import { z } from "zod";
import * as whatsapp from "wa-multi-session";
import { HTTPException } from "hono/http-exception";

// Definisikan tipe untuk hasil pengiriman
interface SentResult {
  to: string;
  id: any; // Tipe ID bisa bervariasi, 'any' lebih aman di sini
}

interface FailedResult {
  to: string;
  error: string;
}

// Skema untuk endpoint broadcast (satu pesan ke banyak nomor)
const sendBroadcastSchema = z.object({
  sessionId: z.string().min(1),
  recipients: z.array(z.string().min(10)).min(1),
  message: z.string().min(1),
});

// Skema untuk endpoint bulk (banyak pesan unik ke banyak nomor)
const sendBulkSchema = z.object({
    sessionId: z.string().min(1),
    messages: z.array(z.object({
        to: z.string().min(10),
        text: z.string().min(1),
    })).min(1),
});

export const createMessageController = () => {
  const app = new Hono();

  // Endpoint untuk Sanity Check
  app.get("/health", (c) => {
    return c.json({ ok: true, message: "Message controller is healthy" });
  });

  // Endpoint LAMA untuk mengirim broadcast (satu pesan ke banyak nomor)
  app.post(
    "/send-broadcast",
    zValidator("json", sendBroadcastSchema),
    async (c) => {
      const { sessionId, recipients, message } = c.req.valid("json");

      const session = whatsapp.getSession(sessionId);
      if (!session) {
        throw new HTTPException(404, { message: `Session '${sessionId}' not found.` });
      }

      const results: { sent: SentResult[]; failed: FailedResult[] } = { sent: [], failed: [] };

      for (const recipient of recipients) {
        try {
          const formattedRecipient = recipient.endsWith("@s.whatsapp.net") ? recipient : `${recipient}@s.whatsapp.net`;
          const sentMessage = await whatsapp.sendTextMessage({ sessionId, to: formattedRecipient, text: message });
          results.sent.push({ to: recipient, id: sentMessage?.key?.id });
        } catch (error) {
          results.failed.push({ to: recipient, error: error instanceof Error ? error.message : "Unknown error" });
        }
      }

      return c.json({ message: "Broadcast process completed.", results });
    }
  );

  // Endpoint BARU untuk mengirim pesan bulk yang dipersonalisasi
  app.post(
    "/send-bulk",
    // zValidator("json", sendBulkSchema), // VALIDATOR DIMATIKAN SEMENTARA
    async (c) => {
        const { sessionId, messages } = await c.req.json(); // Ambil data tanpa validasi

        const session = whatsapp.getSession(sessionId);
        if (!session) {
            throw new HTTPException(404, { message: `Session '${sessionId}' not found.` });
        }

        const results: { sent: SentResult[]; failed: FailedResult[] } = { sent: [], failed: [] };

        for (const message of messages) {
            try {
                const formattedRecipient = message.to.endsWith("@s.whatsapp.net") ? message.to : `${message.to}@s.whatsapp.net`;
                const sentMessage = await whatsapp.sendTextMessage({ sessionId, to: formattedRecipient, text: message.text });
                results.sent.push({ to: message.to, id: sentMessage?.key?.id });
            } catch (error) {
                results.failed.push({ to: message.to, error: error instanceof Error ? error.message : "Unknown error" });
            }
        }

        return c.json({ message: "Bulk message process completed.", results });
    }
  );


  return app;
};